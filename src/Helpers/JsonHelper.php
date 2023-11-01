<?php

namespace Bulbakh\Telenorma\Helpers;

class JsonHelper
{
    public static function toJson(array $array): string
    {
        return json_encode($array);
    }
}
