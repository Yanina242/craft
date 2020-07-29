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
               
             <div >   
            <!-- works -->

           
           @foreach($categories as $category)

              <div class="card product"style="width: 200px;height: 200px;margin-right:10px; margin-bottom:8px;margin-left: 10px;padding:10px;color:gray">
                 
                  <div  style="background:url({{ asset('images/categories/'.$category->extension)  }}); height:100%;background-size: 200px 200px; " class="text-center image-cat">
                  <a href="{{ route('searchEventCategory', [$category->id ,  $name]) }}">
                    <button type="button"
                    style="margin-top: 120px;"class="btn btn-success btn-cat">VER
                      PRODUCTOS 
                    </button> 
                    </a>
                  </div>
              </div>
          @endforeach
      
       </div>
              
          </div> 
          <div class="text-center">
           
          </div>
        </div>  

        <div class="text-center">
        <img src="{{ asset('images/line.png')}}" alt=""> 
        </div>
</div>



@endsection