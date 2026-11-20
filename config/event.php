<?php

return [
    'announcement_enabled' => env(
        'EVENT_ANNOUNCEMENT_ENABLED',
        false
    ),

    'start_date' => env('EVENT_START_DATE'),
    'end_date' => env('EVENT_END_DATE'),
];
