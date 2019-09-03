<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
	protected $table="shoppingcarts";
	protected $fillable = ['status','client_id','total','delivery_date'];

	public function ShoppingCartProducts(){
		return $this->hasMany('App\ShoppingCartProduct');
	}

	public function products(){
		return $this->belongsToMany('App\Product','shoppingcart_product');
	}

	public function productsSize(){
		return $this->products()->count();
	}

	public function total(){
		return $this->ShoppingCartProducts()->sum('subTotal');
	}

	public static function findOrCreateBySessionID($shoppingcart_id){
		$shoppingcarts=ShoppingCart::findBySeccion($shoppingcart_id);
		if(empty($shoppingcarts)){
			return ShoppingCart::createWithoutSession();
		}
		else{if ($shoppingcarts->status!='online'){
				return ShoppingCart::createWithoutSession();
			}else{
				return $shoppingcarts;
			}
		}

	}  

	public function scopeSearchOrder($query,$fecha1,$fecha2){
       return $query->whereDate('created_at','>=',$fecha1)
       				->whereDate('created_at','<=',$fecha2);   

    }  

	public static function findBySeccion($shoppingcart_id){
		return ShoppingCart::find($shoppingcart_id);
	}

	public static function createWithoutSession(){
		return ShoppingCart::create([
			'status' => 'online',
			'total'=>0,
			]);
	}

	public function user(){
        return $this->belongsTo('App\User');
    }

     public function client(){
        return $this->belongsTo('App\Client');
    }
}
