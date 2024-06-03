<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view("auto.login");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view("auto.register");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $role_id = 2;
        $request->validate([
            'name'=> 'required|max:50|min:5',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:16',
            'c_password'=>'required',
            'img'=>'required',
        ]);


        $file = $request->file("img");
        $ext = $file->extension();

        $arrExtension = ["jpg","jpeg","png","svg","icon","gif"];
        if($request->password != $request->c_password){//the password not matching

            return redirect()->back()->with("msg_e","الرمز السري غير مطابق");
        }elseif(!in_array($ext,$arrExtension) ){//this file not image

            return redirect()->back()->with("msg_e","الرجاء ادخال صورة ");
        }else{// not have any erorr

            $image_name = time().".".$ext;
            $file->move("imageUser/", $image_name);
            User::create([// insert the data
                'name'=> $request->name,
                'email'=> $request->email,
                'role_id'=>  $role_id ,
                'password'=> Hash::make($request->password),
                'img'=> $image_name,
            ]);

            return redirect()->route("login")->with("msg_s","تم التسجيل بنجاح");
        }

    }

    public function check(Request $request)
    {
        $request->validate([ //Validate Data
            'email'=>'required|email',
            'password'=>'required|min:6|max:16',
        ]);

        $user = User::all()->where("email" ,'=', $request->email)->first();//get Data of user
        $user_c = User::all()->where("email" ,'=', $request->email)->count();//count of email

        if ($user_c > 0 ){//check email
            if(Hash::check($request->password, $user->password)){//check password
               Auth::attempt([
                "email"=> $request->email,
                "password"=> $request->password,
               ]);//login is successfuly

                return redirect()->route("home")->with("msg_s","  تم الدخول بنجاح ");

            }else{//the password in invalid
                return redirect()->back()->with("msg_e", "عذرا الرمز السري خطا");
            }
        }else{//the email in invalid
             return redirect()->back()->with("msg_e", "عذرا الايميل خطا");
        }
    }



    public function logout(){

        Auth::logout();//user logout
        return redirect()->route("login")->with("msg_s","تم تسجيل الخروج بنجاح");
    }

}
