<?php


namespace App\Helpers;


class Slugger
{
    public static function slugify($text){
        return strtolower(str_replace(' ', "_", trim(preg_replace('/[^A-Za-z0-9_\s]/', '', $text))));
    }
}
