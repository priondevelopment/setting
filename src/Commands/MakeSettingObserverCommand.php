<?php

namespace Setting\Commands;

/**
 * This file is part of Setting,
 * a setting management solution for Laravel.
 *
 * @license MIT
 * @company Prion Development
 * @package Setting
 */

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;

class MakeSettingObserverCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'setting:setting_observer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Setting Observer';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Setting model';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/setting_observer.stub';
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return config('setting.observers.settings_observer', 'SettingObserver');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models\Observer';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
