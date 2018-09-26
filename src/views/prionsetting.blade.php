<?php echo '<?php' ?>

return [
    'enable_logging' => true,

    'cache_ttl' => 60,

    /*
    |--------------------------------------------------------------------------
    | Setting Models
    |--------------------------------------------------------------------------
    |
    | These are the models used by Prion Settings
    |
    */
    'models' => [
        /**
         * Setting model
         */
        'settings' => 'App\Models\Setting',

        /**
         * Setting Log model
         */
        'setting_log' => 'App\Models\SettingLog',

    ],

    'tables' => [
        'settings' => 'settings',

        'settings_log' => 'settings_log',
    ],

    'observers' => [
        'settings_observer' => 'App\Models\Observers\SettingObserver',
    ],
];