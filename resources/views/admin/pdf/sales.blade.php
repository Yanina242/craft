@extends('layouts.main')
@section('content')
 <div class="row">
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">REPORTES DE VENTAS</h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                   
                    <thead><tr>
                      <th>N°</th>
                      <th>Reporte</th>
                      <th></th>
                      
                    </tr></thead>
                    <tbody>
                    <tr>
                      <td>1</td>
                      <td>Reporte de Ventas Mensuales</td>
                      <td>
                        <form action="viewReportSales"  method="GET" target="_blank">
                            <div class="col-md-4 pull-left">
                                {!! Field::select('from_number', $months, ['empty'=>'Seleccione un mes'])!!}
                             </div>
                             <div class="col-md-4">

                                 {!! Field::select('to_number', $months, ['empty'=>'Seleccione un mes'])!!}   
                              </div>                           
                              <br> 
                            <button type="submit" class="btn btn-primary">
                                        Ver
                            </button>
                          </form> 
                      </td>
                    
                    </tr>
                      <tr>
                      <td>2</td>
                      <td>Reporte de Productos Vendidos Semanalmente</td>
                      <td>
                       <form action='reportWeeklySales'  method="GET" target="_blank" >
                         
                           <div class="col-md-8 pull-left">
                               <div class="form-group{{ $errors->has('weekDay') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="weekDay" data-date-end-date="0d" placeholder="Seleccione el primer día de la semana" id="weekDay">
                                @if ($errors->has('weekDay'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('weekDay') }}</strong>
                                    </span>
                                @endif
                               </div>
                              
                          </div> 
                          <div class="pull-left">
                                  <button type="submit" class="btn btn-primary">
                                      Ver
                                  </button>
                            
                            </div>                               
                        </form>
                        
                      </td>
                    
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Reporte de Ventas a Clientes</td>
                      <td>
                        <form action='createReportCOrder'  method="GET" target="_blank" >
                          <div class="input-group date">
                             <div class="input-group input-daterange">
                              <div class="input-group-addon">DESDE</div>
                               <div class="form-group{{ $errors->has('fecha1') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="fecha1" data-date-end-date="0d" placeholder="Seleccione una fecha" id="fecha1">
                                @if ($errors->has('fecha1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha1') }}</strong>
                                    </span>
                                @endif
                               </div>
                              <div class="input-group-addon">HASTA</div>
                               <div class="form-group{{ $errors->has('fecha2') ? ' has-error' : '' }}">
                                 <input type="text" class="form-control" name="fecha2" data-date-end-date="0d" placeholder="Seleccione una fecha" id="fecha2">
                                  @if ($errors->has('fecha2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha2') }}</strong>
                                    </span>
                                @endif
                                </div>
                              <div class="input-group-addon">
                                
                                <button type="submit" class="btn btn-primary">
                                      Ver
                                  </button>
                              </div>
                            </div>
                          </div>
                        </form>
                      </td>
                    
                    </tr>
                   
                  </tbody></table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
 </div>
 @endsection

 @section('js')
<script>
  $('.input-daterange input').each(function() {
    $(this).datepicker({
         language: "es",
         autoclose: true,
         format:"yyyy/mm/dd"
    });
});

$('input').each(function() {
    $(this).datepicker({
         language: "es",
         autoclose: true,
         format:"yyyy/mm/dd",
         daysOfWeekDisabled: "1,2,3,4,5,6",
         calendarWeeks: true
    });
});


</script>


 @endsection