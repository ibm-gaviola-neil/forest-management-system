<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        "blood_bag_id",
        "volume_ml",
        "qnty",
        "date_process",
        "province",
        "city",
        "barangay",
        "staff_id",
        "donation_type",
        'user_id',
        'donor_id'
    ];
}
