<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table="products";
    protected $fillable= ['code','name','category_id','line_id','brand_id','wholesale_cant','description','stock','extension','status','purchase_price','wholesale_price','retail_price'];

    public function category(){

        return $this->belongsTo('App\Category');
    }

    public function line(){

        return $this->belongsTo('App\Line');
    }

    public function brand(){

        return $this->belongsTo('App\Brand');
    }

    public function event(){
        return $this->belongsToMany('App\Event') ;
    }
    public function invoice(){
        return $this->belongsToMany('App\Invoice') ;
    }

    public function provider(){
        return $this->belongsToMany('App\Provider') ;
    }

    public function newCode($category_id,$product_code){
        //concatena id o code con id de categoria
        //(string)$var o strval($var)
        if ($category_id<10){
            $category='00'.strval($category_id);
        }elseif ($category_id<100) {
            $category='0'.strval($category_id);
        }else {
            $category=strval($category_id);
        }

        $code=strval($product_code);
        

        return $category.$code;
    }

    public function singleCode($product_code){
        // retorna el codigo del id de categoria
        // intval($string) y substr($var,int ,[int])
        $code=substr($product_code,3);
        return intval($code);


    }

    public function scopeSearchProduct($query,$name){

        return $query->where('name','LIKE',"%" . $name . "%");
                     
    }

    public function scopeSearchProductL($query,$letra){

        return $query->where('name','LIKE', $letra . "%")
                    ->where('status','=','activo');
                    
    }

    public function scopeSearchProductC($query,$category){

        return $query->where('category_id','=',$category);
                     
                             
    }


    public static function productByCode($term){
        return static::select('id', 'name','code','stock','wholesale_price','retail_price','wholesale_cant')
            ->where('code','LIKE',"%$term%")
            ->where('status','=','activo')
            ->get();

    }    

   /* public static function productByCodeProvider($term,$provider_id){
        return $products= DB::table('providers_products as pp')
              ->join('products as p','pp.product_id','=','p.id')
              ->select('*')
              ->where('code','LIKE',"%$term%")
              ->where('status','=','activo')
              ->where('pp.provider_id','=',$provider_id)->get();
    }  */  

     public function requests(){
        return $this->belongsToMany('App\OrderRequest') ;
    }
 
     
}