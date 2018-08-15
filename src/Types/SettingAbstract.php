<?php

namespace Setting\Types;

/**
 * This file is part of Setting,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @company Prion Development
 * @package Setting
 */

interface SettingAbstract
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

    protected $type;

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


    /**
     * Set a Key/Value
     *
     * Either create or update a value
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $setting = $this->getOrCreate($key);
        $setting->value = $value;
        $setting->type = $this->type;
        $setting->save();
        return $this;
    }


    /**
     * Pull existing record or create a new record
     *
     * @param $key
     * @return mixed|Setting\Models\Setting
     */
    private function getOrCreate($key)
    {
        if ($this->exists($key)) {
            $setting = $this->get($key);
        } else {
            $setting = new Setting\Models\Setting;
            $setting->key = $key;
        }

        return $setting;
    }


    /**
     * Retrieve a Record
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $minutes = config('settings.cache_ttl');
        return $this->cache->remember($key, $minutes, function () {
            return Setting\Models\Setting::
                where('key', $key)
                ->orderBy('id', 'DESC')
                ->firstOrFail();
        });
    }


    /**
     * Pull a Setting Value
     *
     * @param $key
     * @return mixed
     */
    public function value($key)
    {
        $setting = $this->get($key);
        return $setting->value;
    }


    /**
     * Check if a Key Exists
     *
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        $minutes = config('settings.cache_ttl');
        $setting = $this->cache->remember("exists:" . $key, $minutes, function (){
            return Setting\Models\Setting::
                select('id')
                ->where('key', $key)
                ->first();
        });

        if (!isset$setting->id))
            return false;

        return true;
    }

}