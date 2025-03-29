<?php

namespace App\Http\Interfaces;

use App\Models\Donor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface DonationRepositoryInterface {

    /**
     * Retrieve a list of donors.
     *
     * @return Collection|LengthAwarePaginator
     */
    public function index(int $donor) : Collection;
}