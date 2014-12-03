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
        //$link = $this->get("link_editor");
        
        //lista przystankow
        $crawler = $client->request("GET", "http://rozklady.mpk.krakow.pl/aktualne/przystan.htm");
        
        $mpk = $crawler->filter('li a')->each(function ($node){
            //$client = new Client();
            //$crawler = $client->request("GET", "http://rozklady.mpk.krakow.pl/aktualne/".$node->attr("href"));



            return array(
                "name" => $node->text(),
                "address" => $node->attr("href")
                ); 
        });

        //lista lini poszczegolnych przystankow
        $crawler = $client->request("GET", "http://rozklady.mpk.krakow.pl/aktualne/p/p0782.htm");
        $mpk = $crawler->filter('li a')->each(function ($node){
            if($node->attr("href") != "przystan.htm"){
                return array(
                    "line" => $node->text(),
                    "destination" => $node->attr("href")
                );
            }
        });


        return array("stops" => $mpk);
    }
}
