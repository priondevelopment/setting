<?php

namespace Setting;

use Exception;
use Setting\Types;

class Setting
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
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Set the Setting Type
     *
     * @param string $type
     * @return $this
     */
    public function type($type='string')
    {
        $type = strtolower($type);

        switch ($type) {
            case 'string':
                return new Types\SettingString($this->app);

            case 'array':
                return new Types\SettingArray($this->app);

            case 'json':
                return new Types\SettingJson($this->app);

            case 'object':
                return new Types\SettingObject($this->app);
        }

        $this->unknownType($type);
    }


    /**
     * Thown an Exceeption for an unknown type
     *
     * @param $type
     * @throws Exception
     */
    private function unknownType($type)
    {
        if (!$type)
            throw new Exception("Setting Type cannot be empty");

        throw new Exception("Setting type is invalid: " . $type);
    }

}