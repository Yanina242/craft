@extends('layouts.my_template')
   
@section('content') 
    
 <div class="content-wrap centering">
      <div class="mi_letter text-center">
          <h1>Nuestros productos</h1>
          <img src="{{ asset('images/line.png')}}" alt=""> 
      </div>
                     
       <div class="row">  
          <div class="col-md-3">
             @include('main.pagine.Catalogo.aside')
           
           </div> 

          <div class="col-md-9">
               
              <div>
                @if(empty($products))
                   <p>No hay datos para mostrar</p>
                @else
                  @foreach($products as $product)

                   @if (!Auth::guest())
                   <div class="card product mystyle">
                     <div>
                       @if($product->extension!=null)
             
                          <img class="img-prod" src="{{ asset('images/products/'.$product->extension)  }}"  width="160" height="150" >
            
                       @endif
                      </div>
                        <div class="text-center">
                           <h5 class="name-prod" style="height: 35px;"><b>{{strtoupper($product->name)}}</b></h5>
                           <div class="mi_letter">
                             <h5>${{$product->retail_price}}c/u</h5>
                           </div>
                          
                        </div>
                        <div class="pull-left">
                            {!!Form::open(['url'=>'/shoppingcartsproducts', 'method'=>'POST', 'class'=>'inline-block'])!!}
                            <input type ='hidden' name='user_id' value="{{Auth::user()->id}}">
                              <input type ='hidden' name='product_id' value="{{$product->id}}">
                              <button type ='submit' class="btn btn-success btn-car" value='Carrito' id="">
                               Agregar al carrito
                              @if(in_array($product->id,$idproducts))
                              <span class="glyphicon glyphicon-check"></span>
                              @else
                              <span class="glyphicon glyphicon-shopping-cart"></span>
                             @endif</button>
                            {!!form::close()!!}
                            </div>
                        <div class="text-right" >
                            <a data-toggle="modal" id="first" data-title="detail" data-target="#favoritesModalProduct{{$product->id}}">
                              <img class="image-info" src="{{ asset('images/informacion3.png ') }}" width="45" height="45"  >
                            </a>
                        
                        </div>
                        
                   </div>
                   @else
                      <div class="card product my_style">
                     <div>
                       @if($product->extension!=null)
             
                          <img class="image-prod" src="{{ asset('images/products/'.$product->extension)  }}"  width="160" height="150" >
            
                       @endif
                      </div>
                        <div class="text-center">
                           <h5 class="name-prod" style="height: 35px;"><b>{{strtoupper($product->name)}}</b></h5>                        
                        </div>
                        <div class="text-right" >

                            <a data-toggle="modal" id="first" data-title="detail" data-target="#favoritesModalProduct{{$product->id}}">
                              <img class="image-info" src="{{ asset('images/informacion3.png ') }}" width="45" height="45"  >
                            </a>
                        
                        </div>
                        
                   </div>
                     



                   @endif 
                    @include('main.pagine.Catalogo.ProductShow')
                  @endforeach
               @endif
             </div>
          </div> 
          <div class="text-center">
           {!!$products->links()!!} 
          </div>
        </div>  

        <div class="text-center">
        <img src="{{ asset('images/line.png')}}" alt=""> 
        </div>
</div>



@endsection