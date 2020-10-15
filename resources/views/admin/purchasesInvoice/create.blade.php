@extends('layouts.main')

@section('content')

  <div class="container-fluid spark-screen">

    <div class="row">
      <div class="col-md-12">

        <!-- Default box -->
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">REGISTRAR FACTURA DE COMPRA</h3>
         </div>
      <div class="box-body">

          {!! Form::model($purchase,['route'=>['purchasesInvoice.storePI',$purchase->id], 'method'=>'POST'])!!}
          <section>
              <div class="row">
                  <div class="col-xs-12">
                                
                      <div class="pull-left">
                         <h3 style="color:gray;"><b>Orden de Compra N°:{{$purchase->id}}</b></h3>
                         
                      </div>

                  </div><!-- /.col -->
              </div>
              <br>

           <div class="border">
                <div class="row ">
                       
                      <div class="col-md-3 pull-left" >
                           
                           {!!Field::text('number_invoice',null)!!}
                       </div>

                       <div class="col-md-3" >
                         <div class="form-group{{ $errors->has('datepicker') ? ' has-error' : '' }}">
                        {!! form::label('Fecha')!!}
                         <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker" name="datepicker" data-date-end-date="0d" value="{{ old('datepicker') }}">
                         
                         </div> 

                          @if ($errors->has('datepicker'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('datepicker') }}</strong>
                                    </span>
                          @endif
                       </div>
                       
                        </div>

                </div>
              </div>
      
              <div class="border">
                <h3>Proveedor</h3>
                <div class="row ">

                         <div class="col-md-3 pull-left" >
                           
                           <h4><strong>Cuit: </strong> {{$purchase->provider->cuit}} </h4>
                           <input id="cuit"  class="form-control mi_factura" value="{{$purchase->provider->cuit}}" type="hidden" >
                       </div>
                       
                      <div class="col-md-6  pull-right">
                            
                            <h4><strong>Nombre: </strong> {{$purchase->provider->name}}</h4>
                            <input id="provider_id" name="provider_id" class="form-control mi_factura" value=" {{$purchase->provider->id}}" type="hidden" >
                            

                      </div>
                </div>
              </div>
              <hr>

              <div class="panel-body borde"><!--busqueda producto-->
                  <h3>Producto</h3>
                <div class="row " >
                    <div class="col-md-3 pull-left" >
                         {!! form::label('Codigo')!!}
                         <input id="code" class="form-control" name="code" type="text" >
                         <input id="product_id" class="form-control " name="product_id" type="hidden" >
                    </div> 
                    <div class="pull-left">
                    <br>
                       <button type="button" class="btn btn-primary pull-left" data-toggle="modal" id="first" data-title="Buscar" data-target="#favoritesModalProduct">
                          <i class="fa fa-search"></i>
                       </button>
                   </div>
                   
                   <div class="col-md-2" style="margin-left: 220px;">
                        {!! form::label('Cantidad')!!}
                        <input class="form-control" id="amount" name="amount" type="number" 
                        onkeyup=""> 
                    </div>
                     <div class="col-md-2">
                       
                        {!!Field::number('purchase_price',null, ['step'=>'any'])!!} 
                      </div>                    
                 </div>
                 <div class="row " >
                    <div class="col-md-6 pull-left ">
                         {!!Field::text('name',null,['disabled'])!!}
                    </div>
                     
                    <div class="col-md-4 pull-left">
                         {!!Field::text('brand',null,['disabled'])!!}
                    </div>


                    <div class="col-md-2 pull-right">
                      <button type="button" id="btn_add" title="Agregar producto" class="btn pull-right">
                      <img src="{{ asset('images/images.png ') }}" width="50" height="50">
                      </button>
                    </div>

                 </div>
              </div>
              <hr>

               <!-- Table row -->
                  <div class="col-xs-12 table-responsive">
                    <table id="details" class="display table table-hover" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Eliminar</th>
                          <th>Nombre</th>
                          <th>Marca</th>
                          <th>Precio Compra</th>
                          <th>Cantidad</th>

                          <th>Subtotal</th>

                        </tr>
                      </thead>

                      <tbody id="detail">

                      @php ($a = 0)
                      @php ($subTotal[$a]=0)
                      @foreach($details as $detail)
                      <tr class="selected" id={{$a}}>
                          <td><button type="button" class="btn btn-danger" onclick="deletefila({{$a}},$('#dsubTotal{{$a}}').val());">X</button></td>
                          <td> <input readonly type="hidden" name="dproduct_id[]" value="{{$detail->product_id}}">{{$detail->product_name}}</td> 

                          <td>{{$detail->brand_name}}</td> 

                          <td>$<input  type="number" name="dprice[]" id="dprice{{$a}}" value="{{$detail->price}}" step="any" onkeyup="calculateSubtotal({{$a}});"></td> 

                         <td><input  type="number" name="damount[]" id="damount{{$a}}" value="{{$detail->amount}}"onkeyup="calculateSubtotal({{$a}});"></td> 

                         <td>$<input id="dsubTotal{{$a}}" name="dsubtTotal" step="any" class="mi_factura" type="number" value="{{$detail->subTotal}}"></td>
                       </tr>
                          
                         
                        @php ($a++) 
                       @endforeach  

                      </tbody>

                    </table>
                  </div><!-- /.col -->


                  <div class="row">
                 
                  <div class="col-xs-6 pull-right">
                      <div class="text-center" style="background-color: gray;">

                        <h3 style="color:white;">Total</h3>

                      </div>
                    <div class="table-responsive">
                      <table class="table">
                        <tr>

                          <th class="text-center">Total:</th>
                          <td class="text-center">$<input type="number" id="totalCompra" name="totalCompra" value="{{$purchase->total}}" step="any" class="mi_factura"></td>

                        </tr>
                      </table>
                    </div>
                  </div><!-- /.col -->
              </div>
        
              <div class="row no-print">
                  <div class="col-xs-12">

                        <div class="form-group text-center">
                         {!! Form::submit('Guardar',['class'=>'btn btn-primary','onclick'=>'verifyProducts()'])!!}
                        <a class="btn btn-danger" href="{{ route('purchases.index') }}">Cancelar</a>
                       </div>
                  </div>
                </div>
              </section><!-- /.content -->
              {!! Form::close() !!}
             </div>
 
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>


 @include('partials.searchProductsPurchase')


@endsection

@section('js')

<script>
// autocompletado de producto por proveedor
var options={
    url: function(q){
       $providerid=$('#provider_id').val();
      
 return  baseUrl('admin/autocompleteProdProvider?q='+q+'&p='+$providerid);
         }, getValue:"code",
            list: {
                    match: {
                        enabled: true
                    },
                    onClickEvent: function () { 
                        var product = $("#code").getSelectedItemData();
                          $('#stock').val(product.stock);
                          $('#product_id').val(product.product_id);
                          $('#name').val(product.product_name);
                          $('#purchase_price').val(product.purchase_price);
                          $('#brand').val(product.brand_name);
                          $('#amount').focus();
                    },
                    onKeyEnterEvent: function () { 
                        var product = $("#code").getSelectedItemData();
                          $('#stock').val(product.stock);
                          $('#product_id').val(product.product_id);
                          $('#name').val(product.product_name);
                          $('#purchase_price').val(product.purchase_price);
                          $('#brand').val(product.brand_name);
                          $('#amount').focus();

                    }
                }
   };
  
  $("#code").easyAutocomplete(options);

$('#favoritesModalProduct').on('shown.bs.modal', function () {
  $('#searchProducts').focus();
});


</script>

<script >
  function complete($id,$code,$brand,$name,$purchase,$stock){
    $('#code').val($code);
    $('#brand').val($brand);
    $('#product_id').val($id);
    $('#name').val($name);
    $('#purchase_price').val($purchase);
    $('#favoritesModalProduct').modal('hide');
    $('#amount').focus();
    $('#mostrar').html('');
    
  };
</script>


<script>
//agrega el producto elegido
    $('#btn_add').on('click',function(){
        invoice_detail();
    });

  var cont=2000;
  var TotalCompra=0;
  var Subtotal=[];

  function invoice_detail(){
    stock=$('#stock').val();
     brand=$('#brand').val();
     code=$('#code').val();
    product_id=$('#product_id').val();
    name=$('#name').val();
    price=$('#purchase_price').val();
    amount=$('#amount').val();
    
  if (product_id!="" && code!="" && name!="" && price!="" && amount>0){

      
         Subtotal[cont]=(amount*price).toFixed(2);
         TotalCompra= (parseFloat($('#totalCompra').val())+parseFloat(Subtotal[cont])).toFixed(2);
         console.log(TotalCompra);

              var fila='<tr class="selected" id="'+cont+'"><td><button type="button" class="btn btn-danger" onclick="deletefila('+cont+','+Subtotal[cont]+');">X</button></td><td> <input readonly type="hidden" name="dproduct_id[]" value="'+product_id+'">'+name+'</td> <td>'+brand+'</td> <td>$<input readonly type="number" name="dprice[]" value="'+price+'" class="mi_factura"></td> <td><input readonly type="number" name="damount[]" value="'+amount+'" class="mi_factura"></td> <td>$'+Subtotal[cont]+'</td> </tr>';
          cont++;
          clear();
        $('#totalCompra').val(TotalCompra);
        $('#details').append(fila);

     
  }else{
        alert("Error al ingresar detalle de la cotización, revise los datos del producto ");
  }
}

function deletefila(index,subTotal){
  console.log(index);
  TotalCompra= (parseFloat($('#totalCompra').val())-subTotal).toFixed(2);
  console.log(subTotal);
  $('#totalCompra').val(TotalCompra);
  $('#'+index).remove();
 }

 function clear(){
    $('#stock').val('');
    $('#code').val('');
    $('#product_id').val('');
    $('#name').val('');
    $('#price').val('');
    $('#amount').val('');
    $('#purchase_price').val('');
    $('#brand').val('');
 }
</script>


<script>
  function productStockProvider(){
     
  }

</script>

<script>
//calcula el subtotal de los productos agregados en la orden de compra
  function calculateSubtotal(number){   
    price= $('#dprice'+number).val();
    amount=$('#damount'+number).val();

    if (price=='' || amount==''){
      price=0;
      amount=0;
    }
    subTotal=parseFloat($('#dsubTotal'+number).val());
 
    $('#dsubTotal'+number).val(parseFloat(amount)*parseFloat(price));

    total=parseFloat($('#totalCompra').val());
    
    total=total-subTotal;
    
    total=total+parseFloat($('#dsubTotal'+number).val());
   
   $('#totalCompra').val(total);
  }

  //verificar que se haya agregado por lo menos un producto
  function verifyProducts(){
  if ($('#totalCompra').val()==0.00) {
    alert("Debe agregar por lo menos un producto");
    event.preventDefault();
  }
}

</script>
<script>
//elegir fecha
$('#datepicker').datepicker({
     language: "es",
     autoclose: true,
     format:'yyyy/mm/dd'
    ,
    })
</script>

<script>
//filtros de productos del modal

 $('#searchProducts').on('keyup', function(){
  $value=$(this).val();
  $.ajax({
    type: 'get',
    url:  "{{ URL::to('admin/searchProducts')}}",
    data:{'searchProducts':$value,'provider_id':{{$purchase->provider->id}}},
    success: function(data){
     
      $('#mostrar').html(data);
    }
    
  })
})


  function SearchLetter($letter){
  $value=$letter;
  $.ajax({
    type: 'get',
    url:  "{{ URL::to('admin/searchLetter')}}",
    data:{'searchL':$value,'provider_id':{{$purchase->provider->id}} },
    success: function(data){
      $('#mostrar').html(data);
    }
    
  });
  }
</script>


@endsection