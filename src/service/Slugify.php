<?php

namespace App\Service;

class Slugify 
{
    public function generate(string $input): string
    {
        $result=str_replace([' ','ç','à'],['-','c','c'],$input);
        $pontuctation=array('.', ',', '?', '!', ':', '_', '.','/');
        $result=str_replace($pontuctation,'',$result);
        $result=trim($result,' '); 
        while(strpos($result,"--")){
            $result=str_replace('--','-',$result);
        }
        $result=trim($result,'-');
        $result=strtolower($result);
        return $result;
    }
}