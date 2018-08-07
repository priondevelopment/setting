<?php

namespace Setting;

use Exception;

class Setting
{

    /**
     * Laravel application.
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Cache Settings
     *
     * @var
     */
    protected $cache;
    protected $cacheTag = 'setting_cache';

    /**
     * Create a new confide instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->cache = app()->make('cache')
            ->tags($this->cacheTag);
    }

}