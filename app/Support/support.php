<?php

use Illuminate\Support\Str;

/**
 * @param $title
 * @param string $separator
 * @return string
 * str_slug 'Türkçe' desteği
 */
function str_slug($title, $separator = '-')
{
    $title = str_replace(['ü', 'Ü', 'ö', 'Ö'], ['u', 'U', 'o', 'O'], $title);
    return Str::slug($title, $separator);
}

