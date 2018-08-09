<?php

namespace PrionSettings;

use PrionSettings\Models;

/**
 * This class is the main entry point of laratrust. Usually this the interaction
 * with this class will be done through the Laratrust Facade
 *
 * @license MIT
 * @package Laratrust
 */

class PrionSettings
{
    /**
     * Laravel application.
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->cache = app('cache')->tags('prionsettings');
    }


    /**
     * Pull a Single, Most Recent Setting Record
     *
     * @param $key
     */
    public function get($key)
    {
        if (! config('prionsettings.use_cache')) {
            return $this->getKey($key);
        }

        return $this->getCache($key);
    }


    /**
     * Pull Cached Version of Key
     *
     * @param $key
     */
    public function getCache($key)
    {
        $cacheKey = 'key:' . $key;
        return $this->cache->($cacheKey, config('cache.ttl', 60), function ($key) {
            return $this->getKey($key)->toArray();
        });
    }


    /**
     * Pull Latest Key from Database
     *
     * @param $key
     * @return mixed
     */
    protected function getKey($key)
    {
        return Models\Setting::
            where('key', $key)
            ->orderBy('id', 'DESC')
            ->first();
    }


    /**
     * Insert a Key/Value Par
     *
     * @param $key
     * @param string $value
     */
    public function create($key, $value='')
    {
        try {
            Models\Setting::insert([
                'key' => $key,
                'value' => $value,
            ]);
        }

        return true;
    }


    /**
     * Update a Key/Value or Throw Exception if Key does not Exist
     *
     * @param $key
     * @param string $value
     * @return bool
     */
    public function update($key, $value='')
    {
        try {
            $setting = Models\Setting::
                where('key', $key)
                ->orderBy('id', 'DESC')
                ->firstOrFail();
        } catch () {
            return false;
        }

        $setting->value = $value;
        $setting->save();

        return $setting;
    }


    /**
     * Update or Create a Key/Value
     *
     * @param $key
     * @param string $value
     */
    public function save($key, $value='')
    {
        try {
            $setting = Models\Setting::
                where('key', $key)
                ->orderBy('id', 'DESC')
                ->firstOrFail();
        } catch () {
            $setting = new Models\Setting;
            $setting->key = $key;
        }

        $setting->value = $value;
        $setting->save();

        return $setting;
    }

}