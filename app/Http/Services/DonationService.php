<?php

namespace App\Http\Services;

use App\Http\Interfaces\DonationRepositoryInterface;
use App\Http\Repositories\DonationRepository;

class DonationService {
    protected $donation_repository;
    public function __construct(
        DonationRepositoryInterface $donation_repository = new DonationRepository()
    ){
        $this->donation_repository = $donation_repository;
    }

    public function getDonationHistories(int $donor){
        return $this->donation_repository->index($donor);
    }
}