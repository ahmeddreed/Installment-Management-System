<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Categories::latest()->Paginate(10);
        return view("main.categories",compact("categories"));
    }

    public function addCategory(Request $request)
    {

        $request->validate([
            'name'=> 'required|max:50|unique:categories',
        ]);

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه الاضافة");
        }

        // insert the data
        Categories::create([
            'name'=> $request->name,
            'user_id'=>auth()->id()
        ]);
        return redirect()->back()->with("msg_s","تم الاضافة بنجاح");
    }


    public function editCategory($id){

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه التعديل");
        }

        $category = Categories::findOrFail($id);
        return view("main.edit-category",compact("category"));
    }



    public function updateCategory(Request $request,$id)
    {

        $request->validate([
            'name'=> 'required|max:50',
        ]);

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه التعديل");
        }

        $update = Categories::find($id);
        $countOfName = Categories::where("name",$request->name)->count();

        if($update){
            if($countOfName > 0 &&  $request->name != $update->name){

                return redirect()->back()->with("msg_e","الاسم محجوز");
            }else{

                $update->name = $request->name ;
                $update->update();
                return redirect()->route("CategoryTable")->with("msg_s","تم التحديث بنجاح");
            }
        }else{
            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }
    }




    public function deleteCategory($id)
    {

        if(auth()->user()->role_id != 1){
            return redirect()->back()->with("msg_e","فقط المدير يمكنه الحذف");
        }

        $category = Categories::find($id);
        if($category){

            $category->delete();
            return redirect()->back()->with("msg_s","تم الحذف بنجاح");
        }else{

            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }

    }
}
