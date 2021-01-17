@extends('layouts.main')

@section('content')

<div class="container-fluid spark-screen">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">REGISTRAR MOVIMIENTO</h3>
          
          </div>
          <div class="box-body">
            
            {!! Form::open(['route'=>'movements.store', 'method'=>'POST'])!!}

            
              {!! Field::text('concept',null, ['class'=>'form-control'])!!}
          
              {!! Field::select('type', ['entrada'=>'entrada','salida'=>'salida'], ['empty'=>'Seleccione un tipo'])!!}
              
              {!!Field::number('rode',null, ['class'=>'form-control','step'=>'any'])!!}

              <div class="form-group text-center">
              {!! Form::submit('Guardar',['class'=>'btn btn-primary'])!!}
               <a class="btn btn-danger" href="{{ route('movements.index') }}">Cancelar</a>
              </div>
          
 
              {!! Form::close() !!}

          </div>
        </div>
      </div>
    </div>
  </div>


@endsection