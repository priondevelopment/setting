<?php

namespace Setting;

/**
 * This file is part of Setting,
 * a setting management solution for Laravel.
 *
 * @license MIT
 * @company Prion Development
 * @package Setting
 */

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'Migration' => 'command.setting.migration',
    ];

    /**
     * The middlewares to be registered.
     *
     * @var array
     */
    protected $middlewares = [];

    protected $cache;
    protected $cacheTag = 'setting_cache';

    public function __construct($app)
    {
        $this->app = $app;
        $this->cache = app()->make('cache')
            ->tags($this->cacheTag);
    }


    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($countries as $country) {
            $path = __DIR__ . '/config/setting/setting.php';
            $publishes[$path] = config_path('setting/setting.php');
        }
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSetting();

        $this->mergeConfig();
    }


    /**
     * Defer Loading Setting
     *
     * @return array
     */
    public function provides()
    {
        return ['setting'];
    }


    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerSetting()
    {
        $this->app->bind('setting', function ($app) {
            return new Setting($app);
        });

        $this->app->alias('setting', 'Setting\Setting');
    }


    /**
     * Merges Config Settings
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/setting.php',
            'setting'
        );
    }
}