<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use App\Models\Categories;
use App\Models\Integrator;
use Illuminate\Http\Request;
use App\Models\PaymentOfPremium;
use Illuminate\Support\Facades\Hash;

class IntegratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $integrator = Integrator::latest()->Paginate(10);
        $categories = Categories::all();
        return view("main.Integrator",compact("integrator","categories"));
    }




    public function addIntegrator(Request $request)
    {

        $request->validate([
            'name'=> 'required|max:50|unique:integrators',
        ]);

        // insert the data
        Integrator::create([
            'name'=> $request->name,
            'user_id'=>auth()->id()
        ]);
        return redirect()->back()->with("msg_s","تم الاضافة بنجاح");
    }





    public function showDetails($id)
    {
        $integrator = Integrator::find($id);
        $shopping = Shopping::where("inte_id",$id)->get();

        if(auth()->user()->role_id != 1 &&  $integrator->user_id != auth()->id()){//he is not manager or he not his staff
            return redirect()->back()->with("msg_e","ليس من صلاحياتك");
        }

        return view("main.show-details",compact("integrator","shopping"));
    }





    public function editIntegrator($id)
    {
        $integrator = Integrator::find($id);
        return view("main.edit-integrator",compact("integrator"));
    }



    public function updateIntegrator(Request $request,$id)
    {

        $request->validate([
            'name'=> 'required|max:50',
            "key"=>"required"
        ]);

        $update = Integrator::find($id);
        $countOfName = Integrator::where("name",$request->name)->count();

        if(auth()->id() != $update->user_id){//he is not manager or he not his staff
            return redirect()->back()->with("msg_e","ليس من صلاحياتك");
        }

        if($update && Hash::check($id,$request->key)){

            if($countOfName > 0 &&  $request->name != $update->name){

                return redirect()->back()->with("msg_e","الاسم محجوز");
            }else{

                $update->name = $request->name ;
                $update->update();
                return redirect()->route("IntegratorTable")->with("msg_s","تم التحديث بنجاح");
            }
        }else{
            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }
    }



    public function deleteIntegrator(Request $request,$id)
    {

        $request->validate([
            "key"=>"required"
        ]);

        $integrator = Integrator::find($id);
        if(auth()->id() != $integrator->user_id){//he is not manager or he not his staff
            return redirect()->back()->with("msg_e","ليس من صلاحياتك");
        }

        if($integrator && Hash::check($id,$request->key)){

            $integrator->delete();
            return redirect()->back()->with("msg_s","تم الحذف بنجاح");
        }else{

            return redirect()->back()->with("msg_e","عذرا يوجد خطا");
        }

    }


}
