<?php

namespace Setting\Types;

use Exception;

class SettingArray extends SettingAbstract implements Setting\Contracts\SettingInterface
{

    protected $type = 'array';

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
        $setting->value = json_encode($value);
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
        $value = json_decode($setting->value);
        $this->checkValue($value);

        return $value;
    }


    /**
     * Make sure the Value is an Array
     *
     * @param $value
     * @return bool
     * @throws Exception
     */
    private function checkValue($value, $key='')
    {
        if (is_array($value))
            return true;

        $this->checkValueException($value, $key);
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

        throw new Exception("The value ". $key ."is not an array");
    }

}