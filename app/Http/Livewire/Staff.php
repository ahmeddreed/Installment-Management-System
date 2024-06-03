<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Staff extends Component
{
    public $showTable = true;//show table of staff
    public $deleteMessage =false;//show delete message
    public $addForm =false;//show form of add a new staff
    public  $user_id,$name,$email,$role_id,$password,$img,$oldImg,$search;//field

    public function render()
    {

        if($this->search == null || $this->search ==""){//not be a search
            $staffs = User::where("id","!=",auth()->id())->paginate(10);
        }else{//be a search
            $staffs = User::where("name",'like', '%'.$this->search.'%')
            ->orWhere('email','like','%'.$this->search.'%')
            ->paginate(10);
        }
        $roles = Role::all();
        return view('livewire.staff',compact("staffs","roles"));
    }

    public function showAddform(){// to show Add Form
        $this->showTable = false;
        $this->addForm = true ;
    }



    public function showDeleteMessage($id){// to show Message of Delete
        $this->user_id =$id;
        $this->showTable = false;
        $this->deleteMessage =true ;
    }


    public function cancel(){//show the Table and close a other item
        $this->showTable = true;
        $this->addForm = false;
        $this->deleteMessage  = false;
        $this->resetData();
    }


    public function resetData(){// to empty all data
        $this->user_id ="";
        $this->name = "";
        $this->email = "";
        $this->password = "";
        $this->role_id = "";
        $this->oldImg = "";
        $this->img = "";
    }

}
