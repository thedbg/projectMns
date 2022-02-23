<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    /**
     * @Route("/profile/{prenom?Dylan}", name="profile")
     */
   function profile($prenom) 
   {
       //$req = Request::createFrontGlobals();
       dd("salut $prenom "); 
   }

    /**  /d = C'est un nombre
     * @Route("/age/{age?2}", name="age", requirements={"age"="\d+"},defaults={"age": 2})
     */
   function age($age) 
   {
   
       #dd("Vous avez $age ans "); 

       #return new Response( '<html><body> vous avez: '.$age.'</body></html>');
       return $this->render('default/index.html.twig', ["age" =>$age]);
   }

    /**
     * @Route("/salle/{salle?2}/seance/{seance?1}", name="salle")
     */
   function salle($salle , $seance) 
   {
      $film = "The Batman";
      return $this->render('salle/index.html.twig' , ["salle" => $salle , "seance" => $seance , "film" => $film]);
   }


}