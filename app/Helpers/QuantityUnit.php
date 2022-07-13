<?php

namespace App\Helpers;

class QuantityUnit
{
    public array $list = [
        'pcs' => 'Pieces',
        'kg' => 'Kilograms',
        'gram' => 'Grams',
        'inch' => 'Inch',
    ];

    public static function new(): QuantityUnit
    {
        return new QuantityUnit();
    }
}
