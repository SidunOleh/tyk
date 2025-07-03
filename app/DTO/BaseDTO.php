<?php

namespace App\DTO;

class BaseDTO
{
    public function toArray(): array
    {
        $arr = [];
        foreach ($this as $name => $val) {
            $name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));
            $arr[$name] = $val;
        }

        return $arr;
    }
}