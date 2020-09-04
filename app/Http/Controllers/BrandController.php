<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;

use App\Brand;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands=Brand::SearchBrandName($request->name)->orderBy('name','ASC')->where('status','=','activo')->paginate(10);
       
        return view('admin.brands.index')->with('brands',$brands)
                                         ->with('searchName', $request->name);;
    

    }


     public function create()
    {
        return view('admin.brands.create');
    }

  
   public function store(BrandRequest $request)
    {
       $brand= new Brand($request->all());
       $brand->name = mb_strtoupper($brand->name);
       $brand->save();
       flash("La marca  ". $brand->name . " ha sido creada con exito" , 'success')->important();
     

       return redirect()->route('brands.index');//redirecciona la categoria
    }

    public function desable($id)
    {
        $brand= Brand::find($id);
        $brand->status='inactivo';
        $brand->save();
        
        return redirect()->route('brands.index');
    }
    

    public function edit($id){
      
      $brand=Brand::find($id);
      return view('admin.brands.edit')->with('brand',$brand);

    }
    
    public function update(Request $request, $id){

     $brand=Brand::find($id);
     $brand->fill($request->all());
     $brand->name = mb_strtoupper($brand->name);
     $brand->save();
    flash("La marca  ". $brand->name . " ha sido modificada con éxito" , 'success')->important();
    

    return  redirect()->route('brands.index');
  }



}
