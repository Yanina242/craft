@extends('layouts.main')

@section('content')
 
<div class="container-fluid spark-screen">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <!-- Default box -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Editar cliente</h3>
          </div>
          <div class="box-body">
            
          {!! Form::model($client,['route'=>['clients.update',$client->id], 'method'=>'PATCH', 'files'=>true])!!}
            
              {!! Field::text('name')!!}

              {!! Field::text('cuil')!!}
              <div class="col-md-6">
              {!! Field::text('address')!!}
              </div>
              <div class="col-md-6">
              {!! Field:: text('location')!!}
              </div>
              <div class="col-md-6">
              {!! Field::text('email')!!}
              </div>
              <div class="col-md-6">
              {!! Field::number('phone')!!}
              </div>
              {!! Form::hidden('bill',0)!!}

              <div class="form-group">
              {!! Form::submit('Guardar',['class'=>'btn btn-primary'])!!}
              </div>
          
 
              {!! Form::close() !!}

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
    </div>
  </div>
@endsection

@section('js')
<script >
  $('#cuil').on('keypress', function(e){

    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);

  });
</script>
@endsection
