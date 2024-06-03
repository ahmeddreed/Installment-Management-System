<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\PaymentOfPremium;
use Illuminate\Support\Facades\Hash;

class PurchasesController extends Controller
{


    public function pay(Request $request,$id)
    {

        //$id for Integrator
        $request->validate([
            'name'=> 'required|max:50',
            'price'=>'required|numeric',
            'firstPayment'=>'required|numeric',
            'cate_id'=>'required',
        ]);

        $price =$request->price;
        $tax = $price * 0.3;
        $priceAfterTax = $price + $tax;

        if($request->firstPayment > $priceAfterTax){//the first payment bigger than price After Tax

            return redirect()->back()->with("msg_e"," عذرا يوجد خطا ادخال الدفعة الاولى");
        }else{

            $shopping = Shopping::create([
                'name'=>$request->name ,
                'price'=>$request->price,
                'tax'=> $tax,
                'priceAfterTax'=>$priceAfterTax,
                'cate_id'=>$request->cate_id,
                'user_id'=>auth()->id(),
                'inte_id'=>$id,
            ]);

            if($shopping){

                $theRest = $priceAfterTax - $request->firstPayment;
                PaymentOfPremium::create([
                    'user_id'=>auth()->id(),
                    'shop_id'=>$shopping->id,
                    'pay'=>$request->firstPayment,
                    'theRest'=>$theRest,
                ]);

            }

            return redirect()->back()->with("msg_s","تم الاضافة بنجاح");
        }

    }



    public function editPay($id)
    {
        $categories = Categories::all();
        $shopping = Shopping::find($id);
        return view("main.edit-purchasesr",compact("categories","shopping"));
    }




    public function updatePay(Request $request,$id)
    {

        //$id for Purchases
        $request->validate([
            'name'=> 'required|max:50',
            'price'=>'required|numeric',
            'cate_id'=>'required',
        ]);

        $updateData = Shopping::find($id);

        if($updateData->countOfPayment() > 1 ){//this shop have a many of payment

            if($updateData->price != $request->price){//change the price

                return redirect()->back()->with("msg_e","عذرا لايمكنك تحديث السعر في حالة اخذك لدفعات من المستخدم");
            }else{// not change the price

                $updateData->name = $request->name;
                $updateData->cate_id = $request->cate_id;
                $updateData->user_id = auth()->id();

                $updateData->update();

                return redirect()->back()->with("msg_s","تم التحديث بنجاح");
            }

        }else{//this shop have a one of payment

            //update data
            $price =$request->price;
            $tax = $price * 0.3;
            $priceAfterTax = $price + $tax ;

            $updateData->name = $request->name;
            $updateData->price = $price;
            $updateData->tax = $tax;
            $updateData->priceAfterTax = $priceAfterTax;
            $updateData->cate_id = $request->cate_id;
            $updateData->user_id = auth()->id();

            //update the rest of this shop
            $upPayment = $updateData->UpdateTheFirstItemOfPayment($priceAfterTax);

            $updateData->update();

            return redirect()->back()->with("msg_s","تم التحديث بنجاح");
        }

    }




    public function deleteShop($id)
    {
        $delShop = Shopping::find($id);
        if($delShop){
            $delShop->delete();
            return redirect()->back()->with("msg_s","تم الحذف بنجاح بنجاح");
        }else{
            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }

    }




    //payment Processes
    public function getPayment(Request $request,$id)
    {
        //$id for Shopping
        $shop_id = $id;
        $payment_id = $request->payment_id;


        $request->validate([
            'paymentValue'=> 'required|numeric',
            'payment_id'=>'required',
        ]);

        if(!Hash::check($shop_id, $payment_id)){

            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }else{

            $shopData  = Shopping::find($id);
            $theRest = $shopData->getTheRest();

            // the rest value not equle the zero and bigger from payment Value and the payment Value not equle zero
            if($shopData->getTheRest() >= $request->paymentValue && $shopData->getTheRest() > 0 && $request->paymentValue > 0){

                $newTheRest = $theRest - $request->paymentValue;
                $payment = $request->paymentValue;
                $newPayment = PaymentOfPremium::create([
                    "pay"=>$payment,
                    "theRest"=>$newTheRest,
                    "shop_id"=>$shop_id,
                    "user_id"=>auth()->id(),
                ]);

                return redirect()->back()->with("msg_s","تم الاضافة بنجاح ");
            }else{

                return redirect()->back()->with("msg_e","عذرا يوجد خطا في ادخال البيانات");
            }
        }

    }



    public function editPayment($paymentId)
    {

        $payment = PaymentOfPremium::find($paymentId);
        $shopData = Shopping::find($payment->shop_id);
        $inte_id = $shopData->inte_id;

        return view("main.edit-payment",compact("payment","inte_id"));
    }


    public function updatePayment(Request $request,$paymentId)
    {

        $hashPaymentId = $request->hashPaymentId;

        $request->validate([
            'paymentValue'=> 'required|numeric',
            'hashPaymentId'=>'required',
        ]);

        if(!Hash::check($paymentId, $hashPaymentId)){

            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }else{

            $updateData = PaymentOfPremium::find($paymentId);
            $oldTheRest = $updateData->pay + $updateData->theRest ;//get an old the rest
            $updateTheRest = $oldTheRest - $request->paymentValue;//updated the rset

            if( $request->paymentValue > $oldTheRest ){ // payment value bigger than old the rest

                return redirect()->back()->with("msg_e","عذرا يوجد خطا في ادخال البيانات");
            }else{ //payment value less  than old the rest

                $updateData->pay = $request->paymentValue;
                $updateData->theRest = $updateTheRest;

                $updateData->update();

                return redirect()->back()->with("msg_s","تم التحديث بنجاح");
            }
        }
    }

}
