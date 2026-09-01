<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Multipart Part Size
    |--------------------------------------------------------------------------
    |
    | Default ukuran satu part multipart upload.
    |
    */

    'part_size_mb' => (int) env(
        'DIRECT_UPLOAD_PART_SIZE_MB',
        50
    ),


    /*
    |--------------------------------------------------------------------------
    | Multipart Limits
    |--------------------------------------------------------------------------
    */

    'max_parts' => (int) env(
        'DIRECT_UPLOAD_MAX_PARTS',
        10000
    ),

    'min_part_size_mb' => (int) env(
        'DIRECT_UPLOAD_MIN_PART_SIZE_MB',
        5
    ),

    'max_part_size_mb' => (int) env(
        'DIRECT_UPLOAD_MAX_PART_SIZE_MB',
        5120
    ),


    /*
    |--------------------------------------------------------------------------
    | Upload Session
    |--------------------------------------------------------------------------
    */

    'session_expire_hours' => (int) env(
        'DIRECT_UPLOAD_SESSION_EXPIRE_HOURS',
        6
    ),


    /*
    |--------------------------------------------------------------------------
    | Presigned URL
    |--------------------------------------------------------------------------
    */

    'presigned_expire_minutes' => (int) env(
        'DIRECT_UPLOAD_PRESIGNED_EXPIRE_MINUTES',
        15
    ),

];
