@extends('layouts.main')

@section('content')

<div class="box box-primary">

     <div class="box-header ">
        <h2 class="box-title col-md-5">Listado de Proveedores</h2>    
        
        <!-- campo de busqueda-->
        <form route='admin.providers.index'  method="GET" class="col-md-3 col-md-offset-4 ">
            <div class="input-group">
              <input type="text" name="name" class="form-control" placeholder="Nombre..."> 
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
          <!-- fin campo de busqueda -->
        
        <input type ='button' class="btn btn-success"  value = 'Agregar' onclick="location.href = '{{ route('providers.create') }}'"/> 

      </div>
     
     <div class="box-body">              
       @if($providers->isNotEmpty())
       <table id="tabla table-striped" class="display table table-hover" cellspacing="0" width="100%">
       
          <thead>
            <tr>
               
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Teléfono</th>
                <th>Provincia</th> 
                <th></th>
            </tr>
          </thead>
     
       
          <tbody>
             @foreach($providers as $provider) 

		          @if ($provider->status!='inactivo')
		            <tr role="row" class="odd">
		          @else
		            <tr role="row" class="odd" style="background-color: rgb(255,96,96);">
		          @endif
		            
		            <td>{{$provider->name}}</td>
		            <td>{{$provider->address}}</td>
		            <td>{{$provider->phone}}</td>
		            <td>{{$provider->province}}</td>
                    <td>
                      <button type="button" class="btn btn-primary " data-toggle="modal" id="first" data-title="Detail" data-target="#favoritesModalProduct" onclick="list({{$provider->id}})">
                          <i class="fa fa-list"></i>
                      </button>
                      
                    
                     @if ($provider->status!='inactivo')
                        <a href="{{route('providers.addProducts',$provider->id)}}" title="agregar productos" >
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-barcode"></i>
                                
                            </button>
                        </a> 
                       <a href="{{route('providers.edit',$provider->id)}}"  >
                            <button type="submit" class="btn btn-warning">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>
                                
                            </button>
                        </a> 

                        

                        <a href="{{route('providers.desable',$provider->id)}}" onclick="return confirm('¿Seguro dará de baja este proveedor?')">
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" ></span>
                            </button>
                        </a> 
                    @else
                       <a href="{{route('providers.enable',$provider->id)}}" onclick="return confirm('¿Seguro desea dar de alta este proveedor?')">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </button>
                         </a>

                    @endif
                    @include('admin.providers.providerProduct')
                  </td>
		           
              </tr>
               @endforeach
            </tbody>
        </table>
        <div class="text-center">
          {!!$providers->render()!!}
        </div>

@else
<div class="alert alert-dismissable alert-warning">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <p>No se encontró ningún proveedor.</p>
</div>

@endif

    </div>

</div>


@endsection


@section('js')

<script>
function list($id){
 
  $.ajax({
    type: 'get',
    url:  "{{ URL::to('admin/listProducts')}}",
    data:{'provider_id':$id},
    success: function(data){
      $('#mostrar').html(data);
    }
    
  })
}
</script>
@endsection