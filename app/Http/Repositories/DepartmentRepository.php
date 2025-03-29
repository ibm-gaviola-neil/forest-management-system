<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface{
    
    protected $department;

    public function index() {
        return Department::orderBy('department_name', 'asc')->get();
    }

    public function show($department){
        return $this->department->find($department);
    }

    public function delete($department){

    }

    public function edit(int $department, $data = array()){}

}