<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Domains\TraitAdmin;
use App\Http\Services\DepartmentService;
use App\Models\BloodIssuance;
use App\Models\Department;
use App\Models\DepartmentHead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentConroller extends Controller
{
    use TraitAdmin;
    protected $department_service;

    public function __construct(DepartmentService $department_service){
        $this->department_service = $department_service;
    }

    public function index(){
        $departments = $this->department_service->getDepartments();
        return view('Pages.Admin.departments', compact('departments'));
    }

    public function store(\App\Http\Requests\DepartmentRequest $request){
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;

        try {
            DB::transaction(function () use ($payload) {
                $department = Department::create($payload);
                DepartmentHead::create([
                    'department_id' => $department->id,
                    'department_head' => $payload['department_head'],
                    'status' => 1,
                ]);
            });
            return redirect()->back()->with('success', 'Department created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    public function delete(Department $department){
        $users = User::where('department_id', $department->id)->get();
        $bloodIssuance = BloodIssuance::where('department_id', $department->id)->get();

        if(count($users) > 0 || count($bloodIssuance) > 0){
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
        return response()->json([
            'department' => $department,
            'department_head' => DepartmentHead::where('department_id', $department->id)->orderBy('status', 'Desc')->get()
        ]);
    }

    public function update(Department $department, Request $request){
        $payload = $request->validate([
           'department_name' => 'required',
            'department_head' => 'required',
            'email' => 'required|email',
            'contact_number' => ['required','regex:/^(09|\+639)\d{9}$/', 'min:11'],
        ]);
        $preDepartment = clone $department;

        $save = $department->update($payload);

        if(!$save){
            return response()->json([
                'status' => 500,
                'message' => 'Unable to edit this department, please try again'
            ]);
        }
        
        $this->storeDepartmentHead($payload, $preDepartment);
        return response()->json([
            'status' => 200,
            'message' => 'Department edited successfuly'
        ]);
    }

    private function storeDepartmentHead($payload, Department $department): bool
    {
        if (
            isset($payload['department_head']) &&
            $department &&
            $payload['department_head'] !== $department->department_head
        ) {
            DB::transaction(function () use ($department, $payload) {
                DepartmentHead::where('department_head', $department->department_head)
                    ->update(['status' => 0]);

                $presentDepHead = DepartmentHead::where('department_head', $payload['department_head'])->first();

                if ($presentDepHead) {
                    $presentDepHead->status = 1;
                    $presentDepHead->save();
                    return;
                }
    
                $toStore = [
                    'department_id'      => $department->id,
                    'department_head'     => $payload['department_head'],
                    'status' => 1,
                ];
    
                DepartmentHead::create($toStore);
            });
            return true;
        }
        // No change, no history entry
        return false;
    }

    public function headHistories(Department $department) 
    {
        $histories = DepartmentHead::where('department_id', $department->id)
            ->orderBy('status', 'Desc')->get();

        return response()->json(
            $histories->map(function ($item) {
                return [
                    'department_head' => $item->department_head,
                    'status' => $item->status,
                    'created_at' => $item->created_at->format('M d, Y h:i A'),
                ];
            })
        );
    }
}
