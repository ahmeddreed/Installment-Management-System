<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{


    public function index()
    {

        $roles = Role::latest()->Paginate(10);
        return view("main.role",compact("roles"));
    }



    public function addRole(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:50|unique:roles',
        ]);

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه الاضافة");
        }

        // insert the data
        Role::create([
            'name'=> $request->name,
        ]);

        return redirect()->back()->with("msg_s","تم الاضافة بنجاح");
    }


    public function editRole($id){

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه التعديل");
        }

        $role = Role::findOrFail($id);
        return view("main.edit-role",compact("role"));
    }



    public function updateRole(Request $request,$id)
    {

        $request->validate([
            'name'=> 'required|max:50',
            'key'=> 'required',
        ]);

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه التعديل");
        }

        $update = Role::find($id);
        $countOfName = Role::where("name",$request->name)->count();

        if($update && Hash::check($id,$request->key)){
            if($countOfName > 0 &&  $request->name != $update->name){

                return redirect()->back()->with("msg_e","الاسم محجوز");
            }else{

                $update->name = $request->name ;
                $update->update();
                return redirect()->route("roleTable")->with("msg_s","تم التحديث بنجاح");
            }
        }else{
            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }
    }




    public function deleteRole(Request $request,$id)
    {

        $request->validate([
            'key'=> 'required',
        ]);

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه الحذف");
        }

        $role = Role::find($id);
        if($role && Hash::check($id,$request->key)){

            $role->delete();
            return redirect()->back()->with("msg_s","تم الحذف بنجاح");
        }else{

            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }

    }
}
