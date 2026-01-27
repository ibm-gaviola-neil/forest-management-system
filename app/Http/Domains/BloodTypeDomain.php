<?php

namespace App\Http\Domains;

class BloodTypeDomain
{
    const BLOOD_TYPE = [
        'A+',
        'A-',
        'B+',
        'B-',
        'AB+',
        'AB-',
        'O+',
        'O-'
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

    const REASONS_FOR_REJECTION = [
        [
            'itemId' => 1,
            'reason' => 'Incomplete documentation. Missing required harvesting plan details.'
        ],
        [
            'itemId' => 2,
            'reason' => 'Forest management guidelines not followed in proposed cutting area.'
        ],
        [
            'itemId' => 3,
            'reason' => 'Environmental impact assessment failed to address protected species in the area.'
        ],
        [
            'itemId' => 4,
            'reason' => 'Proposed cutting volume exceeds allowable limits for the specified zone.'
        ],
        [
            'itemId' => 5,
            'reason' => 'Application conflicts with existing land use designations or protected areas.'
        ],
        [
            'itemId' => 6,
            'reason' => 'Insufficient reforestation plan for post-harvest restoration.'
        ],
        [
            'itemId' => 7,
            'reason' => 'Improper road access planning that could cause erosion or habitat disruption.'
        ],
        [
            'itemId' => 8,
            'reason' => 'Cutting timeframe conflicts with breeding seasons of local wildlife.'
        ],
        [
            'itemId' => 9,
            'reason' => 'Inadequate buffer zones proposed for riparian areas or water bodies.'
        ],
        [
            'itemId' => 10,
            'reason' => 'Application contains inaccurate GPS coordinates or boundary markers.'
        ],
        [
            'itemId' => 11,
            'reason' => 'Proposed methods violate sustainable forestry practices guidelines.'
        ],
        [
            'itemId' => 12,
            'reason' => 'Failure to include required consultation with indigenous communities.'
        ]
    ];


    const REASONS_FOR_CHAINSAW_REJECT = [
        [
            'itemId' => 1,
            'reason' => 'Chainsaw serial number does not match the documentation provided.'
        ],
        [
            'itemId' => 2,
            'reason' => 'Missing or invalid Official Receipt for chainsaw purchase.'
        ],
        [
            'itemId' => 3,
            'reason' => 'Chainsaw specifications exceed allowable limits for personal use.'
        ],
        [
            'itemId' => 4,
            'reason' => 'Applicant has outstanding violations related to forestry regulations.'
        ],
        [
            'itemId' => 5,
            'reason' => 'Incomplete or unclear chainsaw identification markings.'
        ],
        [
            'itemId' => 6,
            'reason' => 'Documentation provided contains inconsistencies or contradictory information.'
        ],
        [
            'itemId' => 7,
            'reason' => 'Chainsaw brand/model is not approved for use in protected areas.'
        ],
        [
            'itemId' => 8,
            'reason' => 'Applicant lacks required training certification for operating professional-grade chainsaws.'
        ],
        [
            'itemId' => 9,
            'reason' => 'Chainsaw appears to be modified from manufacturer specifications.'
        ],
        [
            'itemId' => 10,
            'reason' => 'Supporting documents expired or not currently valid.'
        ],
        [
            'itemId' => 11,
            'reason' => 'Photos submitted do not clearly show the chainsaw serial number.'
        ],
        [
            'itemId' => 12,
            'reason' => 'Chainsaw is already registered under a different name or organization.'
        ],
        [
            'itemId' => 13,
            'reason' => 'Application contains false or misleading information about chainsaw specifications.'
        ],
        [
            'itemId' => 14,
            'reason' => 'Insufficient proof of legal acquisition of the chainsaw.'
        ],
        [
            'itemId' => 15,
            'reason' => 'Engine displacement exceeds the allowed limit for the requested purpose.'
        ],
        [
            'itemId' => 16,
            'reason' => 'Registration request submitted in wrong jurisdiction or administrative area.'
        ],
        [
            'itemId' => 17,
            'reason' => 'Chainsaw appears to be illegally imported without proper documentation.'
        ],
        [
            'itemId' => 18,
            'reason' => 'Verification failed: Physical inspection revealed discrepancies with submitted information.'
        ],
        [
            'itemId' => 19,
            'reason' => 'Previous registration for the same chainsaw was revoked due to violations.'
        ],
        [
            'itemId' => 20,
            'reason' => 'Required government-issued ID or documents missing or invalid.'
        ]
    ];
}
