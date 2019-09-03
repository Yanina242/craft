@extends('layouts.main')
 
 
@section('content')
   
  <div class="container-fluid spark-screen">
    <div class="row">
      <div class="col-md-12">

        <!-- Default box -->
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Venta</h3>
    
           
         </div>
          <div class="box-body">
          <section class="invoice">
                <!-- title row -->
                <div class="row">
                  <div class="col-xs-12">
                    <h3 class="page-header" style="color:gray;">
                        <img src="{{ asset('images/cotillon.png ') }}" width="230" height="80"  >
                     
                      <div class="pull-right">
                         <b id="id">Venta N°: {{$invoice->id}}</b><br><br>
                         <b>Fecha: {{$invoice->created_at->format('d-m-Y')}}</b>
                      </div>
                      
                    </h3>
                  </div><!-- /.col -->
                </div>
              <div class="row">
               <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-6 invoice-col">
            DE
            <address>
              <strong>Cotillon creaTu</strong><br>
              Direccion:Roque Saenz Peña Nro 14 bis 2 <br>
              B° San Martin,Rosario de Lerma, Salta<br>
              Telefono: (387)59662005 - (387) 5910201<br>
              Email:creatucotillon@gmail.com
            </address>
          </div><!-- /.col -->
          <div class="col-sm-6 invoice-col">
            A
            <address>
              <strong>SR/A :  {{$invoice->client->name}}</strong>
            </address>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
              </div>
                <!-- info row -->
      <div class="panel panel-default">
          <div class="panel-body ">
                <!-- Table row -->
                <div class="row">
                  <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Codigo</th>
                          <th>Producto</th>
                          <th>Descripcion</th>
                          <th>Cantidad</th>
                          <th>Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($detalles as $detalle )
                        <tr>
                          <td>{{$detalle->id}}</td>
                          <td>{{$detalle->name}}</td>
                          <td>{{$detalle->description}}</td>
                          <td>{{$detalle->amount}}</td>
                          <td>$ {{  $detalle->subTotal}}</td>
                        </tr>
                      @endforeach 
                      </tbody>
                    </table>
                  </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                
                  <div class="col-xs-6">
                  </div>
                  <div class="col-xs-6">
                  <div class="text-center" style="background-color: gray;">
                    <h3 style="color:white;">Total</h3>
                    </div>
                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Subtotal:</th>
                          @if($invoice->discount!=0)
                            <td>$ {{($invoice->total/9)*10}}</td>
                          @else
                            <td>$ {{$invoice->total}}</td>
                          @endif
                        </tr>
                        <tr>
                          <th>Descuento</th>
                          <td>{{$invoice->discount}}%</td>
                        </tr>
                        <tr>
                          <th>Total:</th>
                          <td>$ {{$invoice->total}}</td>
                        </tr>
                      </table>
                    </div>
                  </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-xs-12">
                     
                     @if ($invoice->status != 'inactivo')
                      <div class="form-group">
                        <a href="{{route('invoices.pdf',$invoice->id)}}" target="_blank" > <button  type="button" class="btn btn-primary "  ><i class="fa fa-print"></i> 
                      Generar PDF</button></a>
                       </div>
                     @endif
                  </div>
                </div>
              </section><!-- /.content -->

             
 
             

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
    </div>
  </div>




@endsection

