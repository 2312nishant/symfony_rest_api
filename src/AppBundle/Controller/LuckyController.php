<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number/{max}")
     */
    public function  numberAction($max=1000,LoggerInterface $logger)
    {     
        $logger->info('We are logging!');
        $number = mt_rand(0, $max);
       /* Either we can send the response back
        * return new Response(
                '<html><body>Luckyyyy Number: ' . $number . '</body></html>'
        );*/
        
        // Or we can render the html using twig
        return $this->render('default/number.html.twig',array('number' => $number));
    }
    
     /**
     * @Route("/lucky/route")
     */
    public function routeAction() {
         return $this->redirectToRoute('/lucky/number/', array('max' => 1200));
    }
    
}
