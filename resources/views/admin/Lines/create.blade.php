@extends('layouts.main')
 
 
@section('content')
  <div class="container-fluid spark-screen">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <!-- Default box -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">NUEVA LINEA</h3>
          </div>
          
          <div class="box-body">
            
            {!! Form::open(['route'=>'lines.store', 'method'=>'POST'])!!}

             <div class="form-group">
              {!! Field::text('name',null, ['class'=>'form-control'])!!}
             </div>


              <div class= "form-group">
  
              {!! Form::label('status','Estado')!!}
              {!! Form::select('status', ['activo'=>'activo','inactivo'=>'inactivo'],null,['class'=>'form-control'])!!} 
              </div>

              <div class="form-group text-center">
              {!! Form::submit('Guardar',['class'=>'btn btn-primary'])!!}
               <a class="btn btn-danger" href="{{ route('lines.index') }}">Cancelar</a>

              </div>
          
 
              {!! Form::close() !!}

          </div>
          <!-- /.box-body -->
        </div>
        </div>
        <!-- /.box -->

      </div>
    </div>
  </div>
@endsection
