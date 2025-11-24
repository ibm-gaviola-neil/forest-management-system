<?php

namespace App\Http\Controllers\Admin;

use App\Events\AuditStored;
use App\Http\Controllers\Controller;
use App\Http\Domains\TraitAdmin;
use App\Models\City;
use App\Models\Department;
use App\Models\Donor;
use App\Models\Province;
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
            ->where('account_status',  1)
            ->orderBy('last_name')->get();
        return view('Pages.Admin.users', compact('users'));
    }

    public function addUser(){
        $departments = Department::orderBy('department_name')->get();
        $donors = Donor::where('is_approved', 1)
            ->orderBy('last_name')
            ->get()
            ->unique('id')
            ->values();
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
        $payload['account_status'] = 1;
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

    public function update($user = null, Request $request){
        $user_id = $user ?? auth()->user()->id;
        $targetUser = User::where('id', $user_id)->first();
        $payload = array();
        $payload = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users,email,".$targetUser->id,
            "username" => "required|min:6|unique:users,username,".$targetUser->id,
            "province" => 'required',
            "city" => 'required',
            "barangay" => 'required',
        ]);

        if(isset($request['remove_profile_image']) && $request->input('remove_profile_image') == 1){
            $targetUser->profile_image = null;
        }else{
            if($request->hasFile('profile_image')){
                $request->validate([
                    "profile_image" => "nullable|mimes:png,jpg,jpeg",
                ]);
                $fileData = $request->file('profile_image')->store('images', 'public');
                $targetUser->profile_image = $fileData;
            }
        }
        $targetUser->save();

        if ($targetUser->role !== "general_admin") {
            $additional = $request->validate([
                "role" => $targetUser->role === "donor" ? "nullable" : "required",
                "designation" => 'nullable',
                "department_id" => 'nullable',
            ]);
        
            $payload = array_merge($payload, $additional);
        }
        
        if(isset($request->password)){
            $request->validate([
                "password" => 'confirmed|min:6'
            ]);
            
            $payload['password'] = Hash::make($request->password); 
        }

        $donor = Donor::where('id', $targetUser->donor_id)->first();

        if ($donor) {
            $province_name = Province::where('provCode', $request->province)->first();
            $city_name = City::where('citymunCode', $request->city)->first();
            $payload['province'] = $province_name->provDesc;
            $payload['city'] = $city_name->citymunDesc;
            $donor = $donor->update([
                'first_name' => $payload['first_name'],
                'last_name' => $payload['last_name'],
                'province' => $payload['province'],
                'city' => $payload['city'],
                'barangay' => $payload['barangay'],
            ]);
        }

        $save = $targetUser->update($payload);

        if(!$save){
            return redirect()->back()->withErrors(['password'=> 'Cannot make this request, please try again!']);
        }

        if($targetUser->role !== "general_admin"){
            $this->storeAuditTrails('update', 'user', '/users/edit/'.$targetUser->id, 'Account updated');
        }

        return redirect()->back();
    }
}
