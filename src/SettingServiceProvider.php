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

use Setting\Models;

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
        'Config' => 'command.setting.config',
        'Migration' => 'command.setting.migration',
        'ModelSetting' => 'command.setting.model-setting',
        'ModelSettingLog' => 'command.setting.model-setting-log',
        'ModelSettingObserver' => 'command.setting.model-setting-observer',
        'Setup' => 'command.setting.setup',
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
        // Register published configuration.
        $app_path = app()->basePath('config/prionsetting.php');
        $this->publishes([
            __DIR__.'/config/prionsetting.php' => $app_path,
        ], 'prionsetting');

        // Register Logging Observer
        Models\Setting::observe(Models\Observers\SettingObserver::class);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSetting();

        $this->registerCommands();

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
            __DIR__ . '/config/prionsetting.php',
            'prionsetting'
        );
    }


    /**
     * Register the given commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        foreach (array_keys($this->commands) as $command) {
            $method = "register{$command}Command";

            call_user_func_array([$this, $method], []);
        }

        $this->commands(array_values($this->commands));
    }

    protected function registerMigrationCommand()
    {
        $this->app->singleton('command.setting.migration', function () {
            return new \Setting\Commands\MigrationCommand();
        });
    }

    protected function registerModelSettingCommand()
    {
        $this->app->singleton('command.setting.model-setting', function ($app) {
            return new \Setting\Commands\MakeSettingCommand($app['files']);
        });
    }

    protected function registerModelSettingLogCommand()
    {
        $this->app->singleton('command.setting.model-setting-log', function ($app) {
            return new \Setting\Commands\MakeSettingLogCommand($app['files']);
        });
    }


    protected function registerModelSettingObserverCommand()
    {
        $this->app->singleton('command.setting.model-setting-observer', function ($app) {
            return new \Setting\Commands\MakeSettingObserverCommand($app['files']);
        });
    }



    /**
     * Register Command to Setup Settings Service
     *
     */
    protected function registerSetupCommand()
    {
        $this->app->singleton('command.setting.setup', function () {
            return new \Setting\Commands\SetupCommand;
        });
    }


    /**
     * Register Command to Setup Setting Config
     *
     */
    protected function registerConfigCommand()
    {
        $this->app->singleton('command.setting.config', function () {
            return new \Setting\Commands\ConfigCommand;
        });
    }

}