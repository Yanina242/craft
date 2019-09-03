@extends('layouts.main')

@section('content')

<div class="box box-primary">

<div class="box-header ">
<div class="row">
    @if($fecha1 == $fecha2)
             <h2 class="box-title col-md-5">Listado de Facturas de Compra</h2>
    @else
             <h2 class="box-title col-md-8">Listado de Facturas de Compra desde {{date("d-m-Y",strtotime($fecha1))}} hasta {{date("d-m-Y",strtotime($fecha2))}}.</h2>
    @endif
</div>
      <div class="row">
      <div class='col-sm-2 pull-right'>
        <input type ='button' class="btn btn-success"   value = 'Agregar' onclick="location.href = '{{ route('purchasesInvoice.create') }}'"/> 
        </div>
        <div class='col-sm-6 pull-left'>
        <br>
           <form route='purchasesInvoice.index'  method="GET">
              <div class="input-group date">
                 <div class="input-group input-daterange">
                  <div class="input-group-addon">DESDE</div>
                    <input type="text" class="form-control" name="fecha1" data-date-end-date="0d" placeholder="Seleccione una fecha">
                  <div class="input-group-addon">HASTA</div>
                  <input type="text" class="form-control" name="fecha2" data-date-end-date="0d" placeholder="Seleccione una fecha">
                  <div class="input-group-addon">
                        <button type="submit" class="btn btn-primary">
                                  <i class="fa fa-calendar"></i>
                                  </button>
                  </div>
                </div>
              </div>

            </form>

        </div>
      </div>

</div>

<div class="box-body">              
 @if($purchases->isNotEmpty()) 
 <table id="tabla table-striped" class="display table table-hover" cellspacing="0" width="100%">
       
        <thead>
            <tr>
                <th width="15%" class="text-center">N° Factura Compra</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th></th>

                 
            </tr>
        </thead>
     
       
<tbody id="mostrar">
   @foreach ($purchases as $key => $purchase) 
         
                @if ($purchase->status!='rechazada' )
                  
                <tr>
                              
                        <td class="text-center">{{$purchase->pi_id}}</td>
                        
                        <td>{{$purchase->created_at->format('d/m/Y')}}</td>
                        <td>{{$purchase->provider->name}}</td>
                        <td>${{$purchase->total}}</td>
                       
                        <td><a href="{{route('purchasesInvoice.show',$purchase->id)}}" > <button  type="button" class="btn btn-info "  ><span class="fa fa-list" aria-hidden="true" ></span></button></a>
                        <a href="{{route('purchasesInvoice.edit',$purchase->id)}}"  >
                                <button type="submit" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>
                            
                                </button>
                        </a>



                        </td>
                  </tr>

                    @endif
                         
        @endforeach

      </tbody>
    </table>
    <div class="text-center">
         {!!$purchases->render()!!}
    </div>

 @else
        <div class="alert alert-dismissable alert-warning">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <p>No se encontró ninguna factura de compra.</p>
        </div>

  @endif

  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">

$('.input-daterange input').each(function() {
    $(this).datepicker({
         language: "es",
         autoclose: true,
         format:"yyyy/mm/dd"
    });
});


</script>

<script type="text/javascript">
function myDelete(id){
  $.ajax({

type: "POST",
url: "{{ URL::to('admin/purchases/desable')}}",
data: { id: id }
});

}
</script>


@endsection