<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function startDate(){

        $date = "";
        $year =date("Y");
        $muonth =date("m");
        $day =date("d");

        return $year."-".$muonth."-".$day;
    }



    public function endDate(){

        $date = "";
        $year =date("Y");
        $muonth =date("m");
        $day =date("d");

        if($muonth == 12);

    }

    public function index()
    {
        // date of payment and date of the rest
        // $year =date("Y");

        // $muonth =date("m")+1;
        // $day =date("d");

        // $date = $year."-".$muonth."-".$day;
        // // $startDate = $muonth."-".$day;
        // // $endDate = $muonth+1 ."-".$day;

        // dd(today()->diffInDays($date));


        $myData  = User::find(auth()->id());

        // dd(today()->diffInDays($myData->created_at));
        return view("main.profile",compact("myData"));
    }


    public function editUserData(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:50|min:6',
            'email'=>'required|email',
        ]);

        $update = User::find(auth()->id());
        $checkEmail = User::where("email",$request->email)->count();

        //check if email exsit
        if($checkEmail > 0){
            if($update->email != $request->email){//the email exsit

                return redirect()->back()->with("msg_e","هذا الايميل محجوز");
            }else{//the email is not exsit or not change the email
                $update->name = $request->name;
                $update->email = $request->email;
            }
        }

        if($request->hasFile("img")){

            $file = $request->file("img");
            $ext = $file->extension();
            $arrExtension = ["jpg","jpeg","png","svg","icon","gif"];

            if(!in_array($ext,$arrExtension) ){//this file not image

                return redirect()->back()->with("msg_e","الرجاء ادخال صورة ");
            }else{// not have any erorr

                $image_name = time().".".$ext;
                $file->move("imageUser/", $image_name);
            }

            $update->img = $request->img;
        }

        // update the data
        $update->update();
        return redirect()->back()->with("msg_s","تم تحديث البيانات بنجاح");

    }



    public function password()
    {

        return view("main.change-password");
    }


    public function changePassword(Request $request)
    {

        $request->validate([
            'passwordOld'=> 'required|min:6|max:16',
            'passwordNew'=>'required|min:6|max:16',
            'c_passwordNew'=>'required|min:6|max:16',
        ]);


        if($request->passwordNew != $request->c_passwordNew){

            return redirect()->back()->with("msg_e","الرجاء تطابق رمز السري الجديد");
        }else{

            $userData = User::find(auth()->id()); // data of this user
            //check password
            if(!Hash::check($request->passwordOld, $userData->password)){//the password is not correct

                return redirect()->back()->with("msg_e"," رمز السري القديم غير صحيح");
             }else{//the password is correct

                $userData->password =  Hash::make($request->passwordNew);
                $userData->update();
                return redirect()->route("profile")->with("msg_s","  تم التعديل  بنجاح ");
             }

        }
    }
}
