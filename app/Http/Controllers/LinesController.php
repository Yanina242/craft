<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LineRequest;

use App\Line;

class LinesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

      $lines=Line::SearchLine($request->name)->orderBy('name','ASC')->where('status','=','activo')->paginate(10);
       
      return view('admin.lines.index')->with('lines',$lines)
                                      ->with('searchName', $request->name);
    }


     public function create()
    {   
        return view('admin.lines.create');
    }

  
    public function store(LineRequest $request)
    {
    	
       $line= new Line($request->all());
       $line->save();
       flash("La linea ". $line->name . " ha sido creada con exito" , 'success')->important();
       

       return redirect()->route('lines.index'); //cambiar cuando cree la lista
    }

   
    public function show($id)
    {
        //
    }

     
    public function edit($id)
    {
         $line= Line::find($id);
         return view('admin.lines.edit')->with('line',$line);
    }

    
    public function update(Request $request, $id)
    {
         $line=Line::find($id);

        $line->fill($request->all());
             

        $line->save();
        flash("La linea ". $line->name . " ha sido modificada con exito" , 'success')->important();
     

       return redirect()->route('lines.index');
    }

    public function destroy($id)
    {
        $line=Line::find($id);
        $line->status='inactivo';
        $line->save();
        return redirect()->route('lines.index');
    }

      public function desable($id)
    {
        $line=Line::find($id);
        $line->status='inactivo';
        $line->save();
        return redirect()->route('lines.index');
    }
}
