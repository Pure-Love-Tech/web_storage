<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Author Information
    |--------------------------------------------------------------------------
    |
    | This section contains information about the author of the configuration.
    |
     */

    'author' => [
        'name' => 'Vironeer', // Author's name
        'email' => 'support@vironeer.com', // Author's email
        'website' => 'https://vironeer.com', // Author's website
        'profile' => 'https://codecanyon.net/user/vironeer', // Author's profile link
    ],

    /*
    |--------------------------------------------------------------------------
    | Item Information
    |--------------------------------------------------------------------------
    |
    | This section contains information about the item.
    |
     */

    'item' => [
        'alias' => 'uptoearn', // Item alias
        'version' => '1.3', // Item version
    ],

    /*
    |--------------------------------------------------------------------------
    | API Information
    |--------------------------------------------------------------------------
    |
    | This section contains information about the API.
    |
     */

    'api' => [
        'license' => 'http://license.vironeer.com/api/v1/license', // API license URL
    ],

    /*
    |--------------------------------------------------------------------------
    | System Configuration
    |--------------------------------------------------------------------------
    |
    | This section contains configuration options for the system.
    |
     */

    'system' => [
        'admin_path' => env('SYSTEM_ADMIN_PATH', 'admin'), // System admin path
        'demo_mode' => env('SYSTEM_DEMO_MODE', false), // System demo mode setting
        'license_type' => env('SYSTEM_LICENSE_TYPE', 1), // System license type
    ],

    /*
    |--------------------------------------------------------------------------
    | Installation Configuration
    |--------------------------------------------------------------------------
    |
    | This section contains configuration options for the installation process.
    |
     */

    'install' => [
        'requirements' => env('INSTALL_REQUIREMENTS', false), // Installation requirements setting
        'file_permissions' => env('INSTALL_FILE_PERMISSIONS', false), // File permissions setting
        'license' => env('INSTALL_LICENSE', false), // Installation license setting
        'database_info' => env('INSTALL_DATABASE_INFO', false), // Database information setting
        'database_import' => env('INSTALL_DATABASE_IMPORT', false), // Database import setting
        'complete' => env('INSTALL_COMPLETE', false), // Installation completion setting
    ],

];
