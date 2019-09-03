<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Porcentage;
use App\Purchase;
use App\PurchaseProduct;
use App\Product;
use Illuminate\Support\Facades\DB;
use App\Movement;


class PurchasesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;
      $purchases=Purchase::where('status','=','realizada')
                            ->orderBy('id','DESC')
                            ->paginate(15);

      if($request->fecha1!='' and $request->fecha2!=''){

         $fecha1=$request->fecha1;
         $fecha2=$request->fecha2;
         $purchases=Purchase::SearchPurchase($request->fecha1,$request->fecha2)
                            ->where('status','=','realizada')
                            ->orderBy('id','DESC')->paginate(15);


     }
      
      return view('admin.purchasesInvoice.index')->with('purchases',$purchases)->with('fecha1',$fecha1)->with('fecha2',$fecha2);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       $title='BUSCAR PROVEEDORES';
       $date=date('d').'/'.date('m').'/'.date('Y');
        return view('admin.purchasesInvoice.create2')->with('title',$title)
                                                      ->with('date',$date);
    }

    public function loadOrder($id){
       
        $purchase=Purchase::find($id);
        $details= DB::table('purchases_products as pp')
              ->join('products as p','pp.product_id','=','p.id')
              ->join('brands as b','p.brand_id','=','b.id')
              ->select('p.id as product_id','p.name as product_name','pp.price','b.name as brand_name','pp.amount','pp.subTotal')
              ->where('pp.purchase_id','=',$id)->get();
        return view('admin.purchasesInvoice.create')->with('purchase',$purchase)
                                                    ->with('details',$details);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
          'cuit'=>'required|exists:providers,cuit',
          'number_invoice'=>'required|max:15|unique:purchases',
          'datepicker'=>'required',

        ]);
        
       

        $purchase = new Purchase;
            $purchase->total=$request->get('TotalCompra');
            
            $purchase->provider_id=$request->get('provider_id');
            
            $purchase->number_invoice=$request->get('number_nvoice');
            $purchase->created_at=date("Y-m-d",strtotime($request->datepicker));

             $purchase->status='realizada';

            if ($purchase->total>0){
                 $purchase->save();
                 $outcome=new Movement();
                 $outcome->concept="Compra N° ".$purchase->id;
                 $outcome->type="salida";
                 $outcome->rode=$purchase->total;
                 $outcome->save();
            }
            else{
                  flash("Debe ingresar al menos un producto" , 'danger')->important();
            }


            //+++++++++++++INICIAMOS CAPTURA DE VARIABLES ARREGLO[] PARA DETALLEDE ordencompra//++++++++++++++++++

            $idarticulo = $request->get('dproduct_id');
            $amount = $request->get('damount');
            $price = $request->get('dprice');

            $cont =0;

            while ( $cont <  count($idarticulo) ) {
                //dd($cont);
                $detalle = new PurchaseProduct();
                $detalle->purchase_id=$purchase->id; //le asignamos el id de la venta a la que pertenece el detalle
                $detalle->product_id=$idarticulo[$cont];

               
                $detalle->amount=$amount[$cont];
                $detalle->price=$price[$cont];
                $detalle->subTotal=$amount[$cont]*$price[$cont];

                if ($purchase->total>0){
                   
                   $product=Product::find($detalle->product_id);

                   if($product->purchase_price != $detalle->price){

                    $product->purchase_price=$detalle->price;
                    $porcentage=Porcentage::all()->last();
                    $product->wholesale_price=$product->purchase_price+(($product->purchase_price*$porcentage->wholesale_porcentage)/100);
                     $product->retail_price=$product->purchase_price+(($product->purchase_price*$porcentage->retail_porcentage)/100);
                   


                    
                   }

                   $product->stock=$product->stock + $detalle->amount;
                   $product->save();

                   $detalle->save();               


                }
                               
                $cont = $cont+1;

            }




           return redirect()->route('purchasesInvoice.index');
    }
    

    public function storePI(Request $request,$id)
    {
      $this->validate($request,[
         
          'number_invoice'=>'required|max:15|unique:purchases',
          'datepicker'=>'required',

        ]);

        $purchase=Purchase::find($id);
        $purchase->status='realizada';
        $purchase->number_invoice=$request->number_invoice;
        $purchase->created_at=date("Y-m-d",strtotime($request->datepicker));
        
        
        DB::table('purchases_products')->where('purchase_id','=',$id)->delete();
        
        $purchase->total=$request->get('totalCompra'); 

      if ($purchase->total>0){

                 $purchase->save();
                 $outcome=new Movement();
                 $outcome->concept="Compra N° ".$purchase->id;
                 $outcome->type="salida";
                 $outcome->rode=$purchase->total;
                 $outcome->save();
            }
            else{
                  flash("Debe ingresar al menos un producto" , 'success')->important();
            }

            $idprod = $request->get('dproduct_id');
            $amount = $request->get('damount');
            $price = $request->get('dprice');

             $cont =0;

            while ( $cont <  count($idprod) ) {
                //dd($cont);
                $detail = new PurchaseProduct();
                $detail->purchase_id=$purchase->id; //le asignamos el id de la venta a la que pertenece el detail
                $detail->product_id=$idprod[$cont];
                $detail->amount=$amount[$cont];
                $detail->price=$price[$cont];
                $detail->subTotal=$amount[$cont]*$price[$cont];

                if ($purchase->total>0){
                   
                   $product=Product::find($detail->product_id);

                   if($product->purchase_price != $detail->price){

                    $product->purchase_price=$detail->price;
                    $porcentage=Porcentage::all()->last();
                    $product->wholesale_price=$product->purchase_price+(($product->purchase_price*$porcentage->wholesale_porcentage)/100);
                     $product->retail_price=$product->purchase_price+(($product->purchase_price*$porcentage->retail_porcentage)/100);
                   
                    
                   }

                   $product->stock=$product->stock + $detail->amount;
                   $product->save();

                   $detail->save();               


                }
                               
                $cont = $cont+1;

            }
            return redirect()->route('purchasesInvoice.index');
    }

    public function show($id)
    {
        $purchaseInvoice= Purchase::find($id);
      $details= DB::table('purchases_products as dp')
      ->join('products as p','dp.product_id','=','p.id')
      ->join('brands as b','b.id','=','p.brand_id')
      ->select('p.id','p.name as product_name','b.name as brand_name','dp.price','dp.amount','dp.subTotal')
      ->where('dp.purchase_id','=',$id)->get();

      return view('admin.purchasesInvoice.detailInvoicePurchase')->with('purchasesInvoice',$purchaseInvoice)
                                                   ->with('details',$details);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseInvoice=Purchase::find($id);
        $details= DB::table('purchases_products as pp')
                          ->join('products as p','pp.product_id','=','p.id')
                          ->join('brands as b','p.brand_id','=','b.id')
                          ->select('p.id as product_id','p.name as product_name','pp.price','b.name as brand_name','pp.amount','pp.subTotal')
                          ->where('pp.purchase_id','=',$purchaseInvoice->id)->get();

        return view('admin.purchasesInvoice.edit')->with('purchaseInvoice',$purchaseInvoice)
                                            ->with('details',$details); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $purchaseInvoice=Purchase::find($id);
      $purchaseInvoice->total=$request->get('TotalCompra'); 

      if ($purchaseInvoice->total>0){
                 $purchaseInvoice->save();
            }
      else{
                  flash("Debe ingresar al menos un producto" , 'success')->important();
            }

        $purchaseProducts=PurchaseProduct::where('purchase_id','=',$id)->get();
                 foreach ($purchaseProducts as $purchaseProduct) {
                   $product=Product::find($purchaseProduct->product_id);
                  $product->stock = $product->stock-$purchaseProduct->amount;
                  $product->save();
                  $purchaseProduct->delete();

                }


            $idarticulo = $request->get('dproduct_id');
            $amount = $request->get('damount');
            $price = $request->get('dprice');

             $cont =0;

            while ( $cont <  count($idarticulo) ) {
                //dd($cont);
                $detalle = new PurchaseProduct();
                $detalle->purchase_id=$purchaseInvoice->id; //le asignamos el id de la venta a la que pertenece el detalle
                $detalle->product_id=$idarticulo[$cont];
                $detalle->amount=$amount[$cont];
                $detalle->price=$price[$cont];
                $detalle->subTotal=$amount[$cont]*$price[$cont];

                if ($purchaseInvoice->total>0){
               
                 $product=Product::find($detalle->product_id);
                $product->stock = $product->stock+$detalle->amount;
                $product->save();
                   $detalle->save(); 
                }
                               
                $cont = $cont+1;

            }

    
        flash("La Factura de Compra N° ". $purchaseInvoice->id . " ha sido modificada con exito" , 'success')->important();
     

       return redirect()->route('purchasesInvoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function completeOrder(Request $request){

       $cont=0;
    $TotalCompra=0;
    $Subtotal=[];
       
       
        if($request->ajax()){  
          
            $purchase = Purchase::find($request->searchP);
            $products= DB::table('purchases_products as pp')
                          ->join('products as p','pp.product_id','=','p.id')
                          ->join('brands as b','p.brand_id','=','b.id')
                          ->select('p.id as product_id','p.name as product_name','pp.price','b.name as brand_name','pp.amount','pp.subTotal')
                          ->where('pp.purchase_id','=',$purchase->id)->get();
         
        
            $comilla="'";
            if ($purchase){
               
                $output='<tr>

                        <td width="20%"><b>CUIT</b><input type="text" id="provider_cuit" name="cuit" value="'.$purchase->provider->cuit.'" class="form-control" disabled></td>
                        <td><br><button type="button" class="btn btn-primary " data                       
                        -toggle="modal" id="second" data-title="Buscar" data-target="#favoritesModalClient" disabled><i class="fa fa-search"></i></button></td>
                        
                        <td><b>Nombre</b><input type="text" id="provider_name" name="name" value="'.$purchase->provider->name.'" class="form-control" disabled>
                              <input id="provider_id" name="provider_id" class="form-control" type="hidden" ></td>
                        </tr>';
                
                            
            return Response($output);

               
               
            }
            else{
                 $output= '
                          

                        <tr>

                        <td width="20%"><b>CUIT</b><input type="text" id="provider_cuit" name="cuit" class="form-control"</td>
                        <td><br><button type="button" class="btn btn-primary " data                       
                        -toggle="modal" id="second" data-title="Buscar" data-target="#favoritesModalClient"><i class="fa fa-search"></i></button></td>
                        
                        <td><b>Nombre</b><input type="text" id="provider_name" name="name"  class="form-control" disabled>
                              <input id="provider_id" name="provider_id" class="form-control" type="hidden" ></td>
                        </tr>';
                
               
                return Response($output);
            }
        }


        
    }


     public function detailPurchase(Request $request){

    $cont=0;
    $TotalCompra=0;
    $Subtotal=[];

    if($request->ajax()){
        $output="";
        $comilla="'";

        $purchase = Purchase::find($request->searchP);
        $products= DB::table('purchases_products as pp')
                          ->join('products as p','pp.product_id','=','p.id')
                          ->join('brands as b','p.brand_id','=','b.id')
                          ->select('p.id as product_id','p.name as product_name','pp.price','b.name as brand_name','pp.amount','pp.subTotal')
                          ->where('pp.purchase_id','=',$purchase->id)->get();
         
        

       if ($products) {
        foreach ($products as $key => $product) {
       
                 $Subtotal[$cont]=0;
                  $output.='
                       <tr class="selected" id="'.$cont.'">
                        <td><button type="button" class="btn btn-danger" onclick="deletefila('.$cont.',$('.$comilla.'#dsubTotal'.$cont.''.$comilla.').val())">X</button></td>
                        <input readonly type="hidden" name="dproduct_id[]" value="'.$product->product_id.'">'.
                        '<td>'.$product->product_name.'</td>'.
                        '<td>'.$product->brand_name.'</td>'.

                        '<td>$<input type="number" name="dprice[]" value="'.$product->price.'"</td>
                        <td><input id="damount" name="damount[]" type="number" value="'.$product->amount.'" onkeyup="$('.$comilla.'#dsubTotal'.$cont.''.$comilla.').val(this.value*'.$product->price.')" onchange="$('.$comilla.'#TotalCompra'.$comilla.').val(parseFloat($('.$comilla.'#TotalCompra'.$comilla.').val())+ parseFloat($('.$comilla.'#dsubTotal'.$cont.''.$comilla.').val()))"> </td>'.
                        '<td>$<input readonly id="dsubTotal'.$cont.'" name="dsubtTotal" class="mi_factura" type="number" value="'.$product->subTotal.'"  ></td>'

                    .'</tr>';
                     $cont++;
                    
        }


   
        return Response($output);
          
       } 

   
    }
    }


}
