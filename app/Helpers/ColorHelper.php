<?php

namespace App\Helpers;

class ColorHelper
{
    public static function randomColor(): string
    {
        $tones = [
            'aplus-bg-light',
            'aplus-bg-dark'
        ];
        $colors = [
            'red',
            'green',
            'blue',
            'orange',
            'teal',
            'violet'
        ];
        return $tones[array_rand($tones)].'-'.$colors[array_rand($colors)];
    }
    public static function randomDarkColor(): string
    {
        $colors = [
            'red',
            'green',
            'blue',
            'orange',
            'teal',
            'violet'
        ];
        return 'aplus-bg-dark-'.$colors[array_rand($colors)];
    }
}
