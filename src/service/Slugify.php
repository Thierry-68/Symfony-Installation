<?php

namespace App\service;

class Slugify 
{
    public function generate(string $input): string
    {
        $result=str_replace($input," ","_");    
        return $result;
    }
}