<?php

namespace App\Models;

use App\Models\Shopping;
use App\Models\PaymentOfPremium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Integrator extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
    ];


    public function shopping(){
        return $this->hasMany(Shopping::class,"inte_id")->get();
    }




    public function countOfShop(){
        $id = $this->id;
        return Shopping::where("inte_id",$id)->count();
    }



    public function countOfTheAllCost(){
        $countOfPrice = 0;
        $integratorId = $this->id;

        $shoppingOfIntegrator = Shopping::where("inte_id",$integratorId)->get();

        foreach ($shoppingOfIntegrator as $item) {

            $countOfPrice +=$item->priceAfterTax;
        }

        return $countOfPrice;
    }


    public function costOfTheRest(){
        $count = 0;
        $subCount = 0;
        $integratorId = $this->id;

        $shoppingOfIntegrator = Shopping::where("inte_id",$integratorId)->get();

        foreach ($shoppingOfIntegrator as $item) {

           $paymemts = PaymentOfPremium::where("shop_id",$item->id)->get();
           foreach ($paymemts  as $paymemt) {

            if($paymemt)
                $subCount = $paymemt->theRest;
           }
           $count+=$subCount;
        }

        return $count;
    }





    public function lastDate(){
        $lDate = ""; //last date
        $integratorId = $this->id;

         $shoppingOfIntegrator = Shopping::where("inte_id",$integratorId)->get();

        foreach ($shoppingOfIntegrator as $item) {
           $paymemts = PaymentOfPremium::where("shop_id",$item->id)->get();
           foreach ($paymemts  as $paymemt) {

            if($paymemt)
                 $lDate = $paymemt->created_at;
           }

        }

        return $lDate;
    }


}
