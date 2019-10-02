<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cotillon;

class MainPagineController extends Controller
{

	public function index(){

 $cotillones= Cotillon::orderBy('id','DESC')->paginate(1);
 

    return view('main.cotillon.index')->with('cotillones', $cotillones);    

	}


	public function create(){
    
    return view('main.cotillon.create');

	}

	public function store(Request $request){

		 $cotillon= new Cotillon($request->all());
		 $cotillon->business_hours= $request->business_hours;
         $cotillon->save();

       return redirect()->route('index'); 

	}
    
    public function edit($id){

    	$cotillon= Cotillon::find($id);

    	return view('main.cotillon.edit')->with('cotillon',$cotillon);


    }

    public function show($id){


    }


    public function update(Request $request, $id){

    	$cotillon=Cotillon::find($id);

    	$cotillon->fill($request->all());
        if($request->file('fotoContacto')){
          $file =$request->file('fotoContacto');
          $extension=$file->getClientOriginalName();
          if ($extension!=$cotillon->image_Contact){
            $path=public_path().'/images/paginaWeb/';
            $file->move($path,$extension);
            $cotillon->image_Contact=$extension;
          }
        }
        if($request->file('fotoNosotros')){
          $file =$request->file('fotoNosotros');
          $extension=$file->getClientOriginalName();
          if ($extension!=$cotillon->image_AboutUs){
            $path=public_path().'/images/paginaWeb/';
            $file->move($path,$extension);
            $cotillon->image_AboutUs=$extension;
          }
        }

    	$cotillon->save();
        flash("Los datos se han guardado con exito" , 'success')->important();
        return redirect()->route('cotillon.edit',1);
    }

     



}
