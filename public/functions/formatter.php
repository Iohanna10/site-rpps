<?php

namespace Functions\Formatter;

class Formatter 
{
    public function tel($number){
        
        if(strlen($number) > 0){
            if(strlen($number) == 10){
                $new = substr_replace($number, '(', 0, 0);
                $new = substr_replace($new, ') ', 3, 0);
                $new = substr_replace($new, '-', 9, 0);
            }
    
            if(strlen($number) == 11){
                $new = substr_replace($number, '(', 0, 0);
                $new = substr_replace($new, ') ', 3, 0);
                $new = substr_replace($new, '-', 10, 0);
            }

            return $new;
        } 

        return '';
        
    }
}