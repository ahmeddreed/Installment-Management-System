<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $staffs = User::where("id","!=",auth()->id())->Paginate(10);

        return view("main.staff",compact("staffs","roles"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addStaff(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:50',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:16',
            'c_password'=>'required',
            'img'=>'required',
        ]);

        // if(auth()->user()->role_id != 1){
        //     return redirect()->back()->with("msg_e"," فقط المدراء يمكنهم الاضافة ");
        // }

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
                'role_id'=>($request->role_id ?$request->role_id:2),
                'password'=> Hash::make($request->password),
                'img'=> $image_name,
            ]);

            return redirect()->back()->with("msg_s","تم الاضافة بنجاح");
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteStaff(Request $request,$id)
    {
        $request->validate([
            "key"=>"required"
        ]);

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه الحذف");
        }

        $deleteStaff = User::find($id);
        if($deleteStaff && Hash::check($id,$request->key)){

            $deleteStaff->delete();
            return redirect()->back()->with("msg_s","تم الحذف بنجاح");
        }else{

            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }
    }
}
