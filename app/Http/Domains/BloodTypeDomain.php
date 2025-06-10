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

    const MONTHS = [
        ['number' => 1,  'name' => 'January'],
        ['number' => 2,  'name' => 'February'],
        ['number' => 3,  'name' => 'March'],
        ['number' => 4,  'name' => 'April'],
        ['number' => 5,  'name' => 'May'],
        ['number' => 6,  'name' => 'June'],
        ['number' => 7,  'name' => 'July'],
        ['number' => 8,  'name' => 'August'],
        ['number' => 9,  'name' => 'September'],
        ['number' => 10, 'name' => 'October'],
        ['number' => 11, 'name' => 'November'],
        ['number' => 12, 'name' => 'December']
    ];

    const EXPORT_HEADING_ISSUANCE = [
        'Blood Unit Serial Number',
        'Patient Last Name',
        'Patient First Name',
        'Email',
        'Mobile Number',
        'Requestor',
        'Blood Type',
        'Date of Crossmatch',
        'Time of Crossmatch',
        'Release Date',
        'Date Added',
    ];

    const EXPORT_HEADING_DONOR = [
        'Donor ID',
        'Blood Unit Serial Number',
        'Donated By',
        'Email',
        'Mobile Number',
        'Blood Type',
        'Expiration Date',
        'Province',
        'Municipality',
        'Barangay',
        'Donation Date',
        'Date Added',
    ];
    

}