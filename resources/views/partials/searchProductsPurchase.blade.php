<!--POPUP-->


 <div class="modal fade" id="favoritesModalProduct" tabindex="-1" 

      role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:lightblue">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick=" $('#mostrar').html('');" >
             <span aria-hidden="true">&times;</span>
             </button>
             <h4 class="modal-title" id="favoritesModalLabel"><b>BUSCAR PRODUCTOS</b></h4>
      </div>
      <div class="modal-body">
<div>
  @include('partials.letter')
   
  <div class="input-group pull-right" >
 
  <input type="text" name="searchProducts" id="searchProducts" class="form-control"   placeholder="Nombre..."> 

  </div>
  <br>
  <br> 
      
        
  <table id="tabla table-striped" class="display table table-hover" cellspacing="0" width="100%">
       
    <thead>
            <tr style="background-color:lightgray">
             <th width="35%">Nombre</th>
                <th>Marca</th>
                <th>Stock</th>
                <th></th>
                   
            </tr>
    </thead>
     
       
       
<tbody id="mostrar">
   
</tbody>
   
    </table>

      </div><!--FIN DEL BODY-->
      <div class="modal-footer">
        <button type="button" 
           class="btn btn-default" 
           data-dismiss="modal" onClick=" $('#mostrar').html('');">SALIR</button>
      </div>
    </div>
  </div>
</div>
<!--FIN POPUP-->


