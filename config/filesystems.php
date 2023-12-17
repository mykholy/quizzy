<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],
        'clients' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/clients',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'cars' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/cars',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'amenities' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/amenities',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'locations' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/locations',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'teachers' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/teachers',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'academicYears' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/academicYears',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'lessons' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/lessons',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'questions' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/questions',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'answers' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/answers',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'units' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/units',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'students' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/students',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'groups' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/groups',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'subjects' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/subjects',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'books' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/books',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ], 'exams' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/exams',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],

        'connectors' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/connectors',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],
        'logo' => [
            'driver' => 'local',
            'root' => base_path() . '/public/images/logo',
            'url' => env('APP_URL') . '/public',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
