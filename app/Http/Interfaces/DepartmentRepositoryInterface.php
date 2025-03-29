<?php

namespace App\Http\Interfaces;

use App\Models\Department;

interface DepartmentRepositoryInterface {
    public function index();
    public function show($department);
    public function delete(Department $department);
    public function edit(int $department, $data = array());
}