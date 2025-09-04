<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Staff Notification Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for staff notifications throughout
    | the application. Email addresses and notification preferences are
    | centralized here for easier maintenance.
    |
    */

    'staff_emails' => [
        'diy_orders' => [
            'marc@daniellefence.net',      // Marc Glogower - Owner
            'cperez@daniellefence.net',    // Chris Perez - Operations
            'Pepe@daniellefence.net',      // Pepe Berrios - Sales
            'SBarron@daniellefence.net',   // Shane Barron - IT/Marketing
            'CDahlman@daniellefence.net',  // Cory Dahlman - Product Coordinator
        ],
        
        'quote_requests' => [
            'marc@daniellefence.net',
            'cperez@daniellefence.net',
            'Pepe@daniellefence.net',
            'SBarron@daniellefence.net',
        ],
        
        'contact_forms' => [
            'SBarron@daniellefence.net',
            'marc@daniellefence.net',
        ],
        
        'emergency_alerts' => [
            'marc@daniellefence.net',
            'SBarron@daniellefence.net',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Define which notification channels to use for different types of
    | notifications. Options: mail, database, slack, etc.
    |
    */

    'channels' => [
        'diy_orders' => ['mail', 'database'],
        'quote_requests' => ['mail'],
        'contact_forms' => ['mail'],
        'emergency_alerts' => ['mail', 'slack'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for notifications to prevent spam
    |
    */

    'rate_limits' => [
        'diy_orders' => 10,        // per hour
        'quote_requests' => 5,     // per hour
        'contact_forms' => 3,      // per hour
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | Whether to queue notifications or send them immediately
    |
    */

    'should_queue' => env('QUEUE_NOTIFICATIONS', true),
    
    'queue_name' => env('NOTIFICATIONS_QUEUE', 'emails'),

];