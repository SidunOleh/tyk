<?php

namespace App\Interfaces;

interface ICalcDistance
{
    public function distanceInKm(array $route): float;
}