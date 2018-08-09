<?php

namespace PrionSettings\Providers;

/**
 * This file is part of Prion Development Users,
 * a role & account management Laravel.
 *
 * @license MIT
 * @package Users
 */

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class PrionSettigsProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'Migration' => 'command.prionsettings:migration',
        'Setup' => 'command.prionsettings.setup',
    ];

    /**
     * The middlewares to be registered.
     *
     * @var array
     */
    protected $middlewares = [
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Register published configuration.
        $this->publishes([
            __DIR__ . '/config/prionsettings.php' => config_path('prionsettings.php'),
        ], 'prionsettigs');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPrionSettings();

        $this->registerCommands();

        $this->mergeConfig();
    }


    /**
     * Register PrionUsers Package in Laravel/Lumen
     *
     */
    protected function registerPrionSettings()
    {
        $this->app->bind('prionsettings', function ($app) {
            return new PrionSettings($app);
        });

        $this->app->alias('prionsettings', 'PrionSettings\PrionSettings');

    }


    /**
     * Register the Available Commands
     *
     */
    protected function registerCommands ()
    {
        foreach (array_keys($this->commands) as $command) {
            $method = "register{$command}Command";

            call_user_func_array([$this, $method], []);
        }

        $this->commands(array_values($this->commands));
    }


    /**
     * Merge Configuration Settings at run time. If the user has not run
     * the configuration setup command, the default setings are merged in
     *
     */
    protected function mergeConfig ()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/prionsettings.php',
            'prionsettings'
        );
    }
}