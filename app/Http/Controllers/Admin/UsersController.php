<?php

namespace App\Http\Controllers\Admin;

use App\Events\AuditStored;
use App\Http\Controllers\Controller;
use App\Http\Domains\TraitAdmin;
use App\Models\Department;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use TraitAdmin;
    public function index() {
        $users = User::where('role', '!=' ,'general_admin')
            ->where('id', '!=' ,auth()->user()->id)
            ->orderBy('last_name')->get();
        return view('Pages.Admin.users', compact('users'));
    }

    public function addUser(){
        $departments = Department::orderBy('department_name')->get();
        $donors = Donor::orderBy('last_name')->get();
        return view('Pages.Forms.add-user', compact('departments', 'donors'));
    }

    public function editUser(User $user){
        $user_data = [];
        $departments = Department::orderBy('department_name')->get();

        if($user->role == 'staff' && $user->department_id != 0){
            $user_data = User::select('users.*', 'departments.department_name', 'departments.id as dep_id')->join('departments', 'users.department_id', '=', 'departments.id')
            ->where('users.id', $user->id)
            ->first();
            // dd($user_data);
        }else{
            $user_data = $user;
        }
        return view('Pages.Forms.edit-user', compact('user_data', 'departments'));
    }

    public function store(\App\Http\Requests\UserRequest $request){
        $payload = $request->validated();
        $payload['password'] = Hash::make($payload['password']);
        $payload['added_by'] = auth()->user()->id;
        $save = DB::transaction(function() use ($payload){
            $isSave = User::create($payload);
            $this->storeAuditTrails('create', 'user', '/users/edit/'.$isSave->id, 'Newly registered user.');
            return $isSave;
        });

        if(!$save){
            return redirect()->back()->withErrors(['password'=> 'Server error! Please try again']);
        }
        return redirect('/users');
    }

    public function delete(User $user){
        $delete = DB::transaction(function() use ($user) {
            $name = $user->last_name .' '.$user->first_name;
            $isDelete = $user->delete();
            $this->storeAuditTrails('delete', 'user', null, $name. ' was deleted.');

            return $isDelete;
        });


        if(!$delete){
            return response()->json([
                'status' => 0
            ]); 
        }

        return response()->json([
            'status' => 1
        ]);
    }

    public function deactivate(User $user){
        if($user->status === 'active'){
            $user->status = 'deactivated';
        }else{
            $user->status = 'active'; 
        }
        $save = $user->save();

        if(!$save){
            return response()->json([
                'status' => 0,
                'user' => $user
            ]); 
        }

        $this->storeAuditTrails('deactivate', 'user', '/users/edit/'.$user->id, 'Account deactivated');
        return response()->json([
            'status' => 1
        ]);
    }

    public function update(User $user, Request $request){
        $payload = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users,email,".$user->id,
            "username" => "required|min:6|unique:users,username,".$user->id,
            "role" => $user->role === "donor" ? "nullable" : "required",
            "designation" => 'nullable',
            "department_id" => 'nullable',
        ]);

        if(isset($request->password)){
            $request->validate([
                "password" => 'confirmed|min:6'
            ]);

            $payload['password'] = Hash::make($request->password); 
        }

        $save = $user->update($payload);

        if(!$save){
            return redirect()->back()->withErrors(['password'=> 'Cannot make this request, please try again!']);
        }

        $this->storeAuditTrails('update', 'user', '/users/edit/'.$user->id, 'Account updated');
        return redirect('/users');
    }
}
