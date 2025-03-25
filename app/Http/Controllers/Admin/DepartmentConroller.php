<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentConroller extends Controller
{
    public function index(){
        $departments = Department::orderBy('department_name', 'asc')->get();

        return view('pages.admin.departments', compact('departments'));
    }

    public function store(\App\Http\Requests\DepartmentRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;

        try {
            Department::create($payload);
            return redirect()->back()->with('success', 'Department created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    public function delete(Department $department){
        $users = User::where('department_id', $department->id)->get();

        if(count($users) > 0){
            return response()->json([
                'status' => 403,
                'message' => 'Unable to delete department, There are some data associated with this department.'
            ]);
        }

        $delete = $department->delete();

        if(!$delete){
            return response()->json([
                'status' => 500,
                'message' => 'Unable to delete department.'
            ]); 
        }

        return response()->json([
            'status' => 200
        ]);
    }

    public function show(Department $department){
        return response()->json($department);
    }

    public function update(Department $department, Request $request){
        $payload = $request->validate([
           'department_name' => 'required',
            'department_head' => 'required',
            'email' => 'required|email',
            'contact_number' => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
        ]);

        $save = $department->update($payload);

        if(!$save){
            return response()->json([
                'status' => 500,
                'message' => 'Unable to edit this department, please try again'
            ]);
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'Department edited successfuly'
        ]);
    }
}
