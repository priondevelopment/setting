<?php

namespace Setting\Types;

use Exception;

class SettingString extends SettingAbstract implements Setting\Contracts\SettingInterface
{

    protected $type = 'string';

}