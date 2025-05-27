<?php

namespace App\Http\Domains;

class BloodTypeDomain {
    const BLOOD_TYPE = [
        'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
    ];

    const BLOOD_TYPES = [
        'a_plus' => 'A+',
        'a_minus' => 'A-',
        'b_plus' => 'B+',
        'b_minus' => 'B-',
        'ab_plus' => 'AB+',
        'ab_minus' => 'AB-',
        'o_plus' => 'O+',
        'o_minus' => 'O-',
    ];

    const SUFFIX = [
        "",
        "Jr",
        "Sr",
        "I",
        "II",
        "IV",
    ];

}