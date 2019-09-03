@extends('layouts.main')
 
 
@section('content')
  <div class="container-fluid spark-screen">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <!-- Default box -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Modificar producto</h3>
           </div>
          <div class="box-body">
            
            {!! Form::model($product,['route'=>['products.update',$product->id], 'method'=>'PATCH', 'files'=>true])!!}

              <div class= "col-md-4">
              {!!form::label('Producto: ')!!}
              {{ $product->name }}
              </div>

              <div class= "col-md-4">
              {!!form::label('Codigo: ')!!}
              {{ $product->code}}
              </div>

              <div class= "col-md-4">
              {!!form::label('Categoria: ')!!}
              {{$product->category->name}}
              </div>

              <div>
                   {!!form::label('Imagen Actual: ')!!} <img src="{{ asset('images/products/'.$product->extension)  }}" width="40" height="40" > 
              </div>

             <div class="form-group">
              {!! Form::label('image','Nueva Imagen')!!}
              {!! Form::file('image')!!}
             </div>
              
              <div class= "form-group">
              {!! Form::label('events','Evento')!!}
              {!! Form::select('events[]', $events ,$productEvent, ['class'=>'form-control select-tag','multiple'])!!}
              </div> 

              <div class= "form-group">
              {!! Form::label('line_id','Linea')!!}
              {!! Form::select('line_id', $lines ,$product->line->id, ['class'=>'form-control'])!!} 
              </div> 

              <div class= "form-group">
              {!! Form::label('brand_id','Marca')!!}
              {!! Form::select('brand_id', $brands ,$product->brand->id, ['class'=>'form-control'])!!} 
              </div> 

              <div class="form-group">
              {!! Form::label('description','Descripcion')!!}
              {!! Form::text('description',$product->description, ['class'=>'form-control'])!!}
              </div>

              @if($product->brand->name=="CREATÚ")

                  <div class="controls col-md-4">
                 {!! Field::number('purchase_price',$product->purchase_price, ['class'=>'form-control','step'=>'any'])!!}
                 </div>

                  <div class="col-md-3 col-md-offset-1">
                  {!! Field::number('wholesale_price',$product->wholesale_price, ['class'=>'form-control','step'=>'any'])!!}
                  </div>
                  <div class="col-md-3 col-md-offset-1">
                  {!! Field::number('retail_price',$product->retail_price, ['class'=>'form-control','step'=>'any'])!!}
                  </div>
              @endif

             {!! Field::number('stock')!!}

              <div class="form-group">
              {!! Form::label('wholesale_cant','Cantidad de venta Mayorista')!!}
              {!! Form::number('wholesale_cant',$product->wholesale_cant, ['class'=>'form-control'])!!}
              </div>

              <div class="form-group">
              {!! Form::submit('Guardar Cambios',['class'=>'btn btn-primary'])!!}
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
<script>
  $('.select-tag').chosen({
    placeholder_text_multiple: "Seleccione los eventos",
  });

</script>
<script >
  $('#purchase_price').on('keyup', function(){
    $('#wholesale_price').val(parseFloat(this.value)+this.value*{{$porcentage->wholesale_porcentage}}/100);
    $('#retail_price').val(parseFloat(this.value)+this.value*{{$porcentage->retail_porcentage}}/100);
  });
</script>
@endsection