<?php

namespace App\Http\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface DonorRepositoryInterface {

    /**
     * Retrieve a list of donors.
     *
     * @return Collection|LengthAwarePaginator
     */
    public function index(object $request, $address = array(), $is_approved) : Collection;
}