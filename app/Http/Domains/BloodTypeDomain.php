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
    
    const PHILIPPINE_GOVT_IDS = [
        "PhilID"             => "Philippine Identification (PhilID) Card / ePhilID",
        "Passport"           => "Passport",
        "Drivers_License"    => "Driver's License (LTO)",
        "PRC_ID"             => "Professional Regulation Commission (PRC) ID",
        "UMID"               => "Unified Multi-Purpose Identification (UMID) Card",
        "SSS_ID"             => "Social Security System (SSS) ID",
        "GSIS_eCard"         => "Government Service Insurance System (GSIS) eCard",
        "Postal_ID"          => "Postal ID",
        "Voters_ID"          => "Voter's ID / COMELEC Certification",
        "TIN_ID"             => "Taxpayer's Identification Number (TIN) ID",
        "OWWA_ID"            => "Overseas Workers Welfare Administration (OWWA) ID",
        "PWD_ID"             => "Person with Disability (PWD) ID",
        "Senior_Citizen_ID"  => "Senior Citizen ID",
        "IBP_ID"             => "Integrated Bar of the Philippines (IBP) ID",
        "NBI_Clearance"      => "National Bureau of Investigation (NBI) Clearance",
        "Police_Clearance"   => "Police Clearance",
        "PhilHealth_ID"      => "PhilHealth ID (Health Insurance Card ng Bayan)",
        "PagIBIG_ID"         => "Pag-IBIG ID / Loyalty Card",
        "Solo_Parent_ID"     => "Solo Parent ID",
        "Barangay_ID"        => "Barangay ID / Certification",
        "Company_ID"         => "Company / Office ID",
        "School_ID"          => "School ID / Student Permit",
        "Firearms_License"   => "Firearms License (PNP)",
        "Seamans_Book"       => "Seaman's Book / Seafarer's ID",
    ];
}