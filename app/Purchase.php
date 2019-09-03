<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table="purchases";
    protected $fillable= ['id','provider_id','total','status','created_at','number_invoice'];

    public function products(){
    	return $this->belongsToMany('App\Product')->withTimestamps();

    }
     public function provider(){

        return $this->belongsTo('App\Provider');
    }
   
    public function scopeSearchPurchase($query,$fecha1,$fecha2){

     return $query->whereDate('created_at','>=',$fecha1)->whereDate('created_at','<=',$fecha2);
    }

    public function scopeSearchPurchaseByMonth($query,$month){

        return $query->where([('created_at'),'=',$month]);

    }

    public function getDetailAttribute(){

      return route('purchases.detailPurchaseOrder',$this->id);
    }
    public function getPdfAttribute(){

      return route('purchases.show',$this->id);
    }


    public function getDeleteAttribute(){

      return route('purchases.desable',$this->id);
    }

    public function getEditAttribute(){

      return route('purchases.edit',$this->id);
    }
    public function getRegisterAttribute(){

      return route('purchasesInvoice.loadOrder',$this->id);
    }
    
}
