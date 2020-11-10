<!--POPUP-->

<div class="modal fade" id="favoritesModalProduct{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLongTitle">{{$product->name}} </h3>
        
      </div>
      <div class="modal-body">

         <div class="row">
                <div class="col-sm-6 col-xs-12 text-center">
                  <img src="{{ asset('images/products/'.$product->extension)}}" width="300" height="300">
                </div>

                <div class="col-sm-6 col-xs-12 text-center">

                        <h4 class="text-left"><b>Descripción: </b>{{$product->description}}</h4>
                        <h4 class="text-left"><b>Marca: </b>{{$product->brand->name}}</h4>
                            
                        @if (!Auth::guest())
                        <div class="mi_letter">
                          <h5 class="text-left"><b>Precio: </b>${{$product->retail_price}} c/u</h5>
                          <h5 class="text-left">${{$product->wholesale_price}} c/u (mayor a {{$product->wholesale_cant-1}} unidades)</h5> 
                        </div>
                              
                        @endif
                       

                </div>
          </div>
        


      </div>
      <div class="modal-footer" style="border-top:none;">
          @if (!Auth::guest())
            {!!Form::open(['url'=>'/shoppingcartsproducts', 'method'=>'POST', 'class'=>'inline-block'])!!}
                  <input type ='hidden' name='user_id' value="{{Auth::user()->id}}">
                  <input type ='hidden' name='product_id' value="{{$product->id}}">
                  <button type ='submit' class="btn btn-success col-md-offset-1" value='Carrito' id="add_cart">
                  @if(in_array($product->id,$idproducts))
                     <span class="glyphicon glyphicon-check"></span>
                  @else
                     <span class="glyphicon glyphicon-shopping-cart"></span>
                  @endif Agregar al carrito</button>
            {!!Form::close()!!}
          @endif
      </div>
    </div>
  </div>
</div>
<!--FIN POPUP-->