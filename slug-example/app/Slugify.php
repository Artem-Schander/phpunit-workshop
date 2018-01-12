<?php
namespace App;

class Slugify
{
    public static function make($string, $delimiter = '-')
    {
        $string = mb_strtolower($string);
        var_dump($string); die();
        $string = str_replace(['ä', 'ö', 'ü', 'ß'], ['ae', 'oe', 'ue', 'ss'], $string);
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $string = preg_replace("/[^a-z0-9\/_|+ -]/", '', $string);
        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
        $string = trim($string, $delimiter);

        return $string;
    }
}
