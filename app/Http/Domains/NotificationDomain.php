<?php

namespace App\Http\Domains;

class NotificationDomain {

    const DONOR_REGISTRATION = 'donor_registration';
    const LOW_STOCK = 'low_stock';
    const EVENT = 'event';
    const BLOOD_DONOR_REQUEST = 'blood_donor_request';
    const DONOR_REQUEST = 'donor_request';

    const RELATED_TABLES = [
        'donor_registration'  => 'donors',
        'event'               => 'events',
        'low_stock'           => 'donation_histories',
        'blood_donor_request' => 'donors',
    ];

    const TYPES_ICONS = [
        'donor_registration' => '<div class="feeds-left bg-green text-white"><i class="fa fa-user"></i></div>',              // Blue, user icon
        'event'              => '<div class="feeds-left bg-green text-white"><i class="icon-calendar"></i></div>',    // Yellow, calendar icon
        'low_stock'          => '<div class="feeds-left bg-green text-white"><i class="fa fa-exclamation-triangle"></i></div>', // Red, warning icon
        'blood_donor_request'=> '<div class="feeds-left bg-green text-white"><i class="fa fa-hand-holding-medical"></i></div>', // Dark blue, medical hand icon
        'donor_request'=> '<div class="feeds-left bg-green text-white"><i class="fa fa-bell"></i></div>', // Dark blue, medical hand icon
    ];

    const TYPES_TITLES = [
        'donor_registration' => 'New Donor Registration',
        'event'              => 'Upcoming Event',
        'low_stock'          => 'Low Blood Stock Alert',
        'blood_donor_request'=> 'Blood Donor Request',
    ];

    const NOTIFICATION_ACCESS = [
        'applicant'              => ['event', 'donor_request'],
        'general_admin'      => ['donor_registration', 'event', 'low_stock', 'blood_donor_request'],
        'staff'              => ['donor_registration', 'event', 'low_stock', 'blood_donor_request'],
    ];

    const NOTIFICATION_ROUTE = [
        'donor_registration' => '/donors/:id/view?notification_id=',
        'event'              => '/events?event_id=:id&notification_id=',
        'low_stock'          => '/low-stocks?notification_id=',
        'blood_donor_request'=> '/requests/:id?notification_id=',
        'donor_request'      => '/donor-page/requests?notification_id=',
    ];
}