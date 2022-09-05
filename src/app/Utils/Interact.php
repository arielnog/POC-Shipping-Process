<?php

namespace App\Utils;

trait Interact
{
    private static function getData(array $data, ...$keys)
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return $data[$key];
            }
        }

        return null;
    }
}
