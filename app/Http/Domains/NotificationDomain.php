<?php

namespace App\Http\Domains;

class NotificationDomain {

    const DONOR_REGISTRATION = 'donor_registration';
    const LOW_STOCK = 'low_stock';
    const EVENT = 'event';
    const BLOOD_DONOR_REQUEST = 'blood_donor_request';

    const RELATED_TABLES = [
        'donor_registration'  => 'donors',
        'event'               => 'events',
        'low_stock'           => 'donation_histories',
        'blood_donor_request' => 'donors',
    ];

    const TYPES_ICONS = [
        'donor_registration' => '<div class="feeds-left bg-info text-white"><i class="fa fa-user"></i></div>',              // Blue, user icon
        'event'              => '<div class="feeds-left bg-warning text-white"><i class="icon-calendar"></i></div>',    // Yellow, calendar icon
        'low_stock'          => '<div class="feeds-left bg-danger text-white"><i class="fa fa-exclamation-triangle"></i></div>', // Red, warning icon
        'blood_donor_request'=> '<div class="feeds-left bg-primary text-white"><i class="fa fa-hand-holding-medical"></i></div>', // Dark blue, medical hand icon
    ];

    const TYPES_TITLES = [
        'donor_registration' => 'New Donor Registration',
        'event'              => 'Upcoming Event',
        'low_stock'          => 'Low Blood Stock Alert',
        'blood_donor_request'=> 'Blood Donor Request',
    ];
}