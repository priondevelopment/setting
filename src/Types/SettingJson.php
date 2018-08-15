<?php
<?php

namespace Setting\Types;

use Exception;

class SettingJson extends SettingAbstract implements Setting\Contracts\SettingInterface
{

    protected $type = 'json';

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
        $this->checkValue($value);

        $setting = $this->getOrCreate($key);
        $setting->value = $value;
        $setting->type = $this->type;
        $setting->save();
        return $this;
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
        $value = $setting->value;
        $this->checkValue($value);

        return $value;
    }


    /**
     * Make sure the Value is an Object
     *
     * @param $value
     * @return bool
     * @throws Exception
     */
    private function checkValue($value, $key='')
    {
        if ($this->isValidJson($value))
            return true;

        $this->checkValueException($value, $key);
    }


    /**
     * Check if Json is Valid
     *
     * @param $json
     * @return bool
     */
    private function isValidJson($json)
    {
        $decoded = json_decode($json);
        if ( !is_object($json) && !is_array($json) ) {
            return false;
        }
        return (json_last_error() == JSON_ERROR_NONE);
    }


    /**
     * Throw Exception for Invalid Key/Value
     *
     * @param $value
     * @param $key
     * @throws Exception
     */
    private function checkValueException($value, $key='')
    {
        if ($key)
            $key = "for key ". $key ." ";

        throw new Exception("The value ". $key ."is valid json");
    }

}