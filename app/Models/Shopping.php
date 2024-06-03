<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'tax',
        'priceAfterTax',
        'user_id',
        'inte_id',
        'cate_id'
    ];


    public function endDate(){

        $endDate = 0;
        $payments = PaymentOfPremium::where("shop_id",$this->id)->get();

        foreach ($payments as $payment) {
            $startDate = $payment->created_at;
            $endDate = today()->diffInDays($startDate);
        }

        return $endDate;
    }



    public function getTheRest(){

        $theRest = 0;
        $shop_id = $this->id;
        $payment = PaymentOfPremium::where("shop_id",$shop_id)->get();

        foreach ($payment as $item) {
            $theRest = $item->theRest;
        }

        return $theRest;
    }



    public function getLastIdOfPayment(){

        $lastId = 0;
        $shop_id = $this->id;
        $payment = PaymentOfPremium::where("shop_id",$shop_id)->get();

        foreach ($payment as $item) {
            $lastId = $item->id;
        }

        return $lastId;
    }


    public function countOfPayment(){

        $shop_id = $this->id;
        return PaymentOfPremium::where("shop_id",$shop_id)->count();
    }


    public function UpdateTheFirstItemOfPayment($theRest){

        $payment_id = ($this->getLastIdOfPayment() ? $this->getLastIdOfPayment():$this->id);
        $updatePayment = PaymentOfPremium::find($payment_id);
        $updatePayment->theRest = $theRest;
        $updatePayment->update();

        return $updatePayment;
    }
}
