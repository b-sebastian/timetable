<?php

namespace Polcode\MpkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Goutte\Client;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/goutte", name="_goutte")
     * @Template()
     */
    public function goutteAction()
    {
        $client = new Client();
        //$mpk = array();
        
        $crawler = $client->request("GET", "http://rozklady.mpk.krakow.pl/aktualne/przystan.htm");
        
        $mpk = $crawler->filter('li a')->each(function ($node){
            //$link = $crawler->selectLink($node->text());
            //print htmlspecialchars( $node->html() );
            return array(
                "name" => $node->text(),
                "address" => $node->selectLink($node->text())->getUri()
                ); 
        });
        
        //echo htmlspecialchars( $crawler->html() );
        
//        $mpk = $crawler->filter('li')->each(function ($node){
//            //$link = str_split($node->html());
//            
//            
//            
//            return array(
//                "name" => $node->text(),
//                "address" => $this->cutHref($node->html())
//                );
//        });
        
        //echo $crawler->filter('li > a')->html();
        
        //var_dump($mpk);
        
        return array("stops" => $mpk);
    }
    
    private function cutHref($link)
    {
        $address = "";
        $linka = str_split($link);        
        
        for($i = 0; $i < strlen($link) - 6; $i++)
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
