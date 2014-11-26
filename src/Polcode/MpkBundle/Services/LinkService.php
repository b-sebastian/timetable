<?php

namespace Polcode\MpkBundle\Services\LinkService;

class Link
{
    private $url;
    
    public function setUrl($url){
        $this->url = $url;
    }
    
    public function cutHref()
    {
        $address = "";
        $linka = str_split($this->url);        
        
        for($i = 0; $i < strlen($this->url) - 6; $i++)
        {
            if ($linka[$i] == "h" && $linka[$i+1] == "r" && $linka[$i+2] == "e" && $linka[$i+3] == "f" && $linka[$i+4] == "=" && $linka[$i+5] == '"')
            {
                while($linka[$i+6] != '"')
                {
                    $address .= $linka[$i+6];
                    $i++;
                }
                return $address;
            }
        }
        
        return false;
    }
}