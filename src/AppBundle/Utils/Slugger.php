<?php

class Slugger
{
    public function sluggify($string)
    {
        $string = strtr($string, 'ĘÓĄŚŁŻŹĆŃęóąśłżźćń', 'eoaslzzcneoaslzzcn');
        return preg_replace(
            '/[^a-z0-9]+/', '-', strtolower(trim(strip_tags($string)))
        );
        
    }
}