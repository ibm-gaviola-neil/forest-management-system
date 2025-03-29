<?php

namespace App\Http\Services;

use App\Http\Interfaces\DepartmentRepositoryInterface;
use App\Http\Repositories\DepartmentRepository;
use App\Models\Department;

class DepartmentService {
    protected $department_repository;

    public function __construct(
        DepartmentRepositoryInterface $department_repository = new DepartmentRepository()
    ){
        $this->department_repository = $department_repository;
    }

    public function getDepartments(){
        return $this->department_repository->index();
    }

    public function getDepartment(int $department){
        return $this->department_repository->show( $department);
    }
}