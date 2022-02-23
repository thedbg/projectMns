<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends AbstractController 
{
    /** 
     * @Route("/" , name ="accueil")
    */
    Public function accueil(){
        
       return $this->render("Navigation/Accueil.html.twig");
       
    }

    /** 
     * @Route("/Films" , name ="Films")
    */
    Public function Films(){
        $Films= [
            "Les dents de la mer", 
            "Spider-man",
            "Lords of the rings" ];

        return $this->render("Navigation/Films.html.twig", ["Films" => $Films]);
     }


     
    /** 
     * @Route("/homeredirect" , name ="homeredirect")
    */
    Public function homeredirect(){

        return $this->redirecttoRoute("Accueil");
     }


     
     /** 
     * @Route("/Cinema" , name ="Cinema")
    */
    Public function Cinema(){
        $Cinema= [
            "Cinema Nancy", 
            "Cinema Servon",
            "Cinema Lomme" ];
        return $this->render("Navigation/Cinema.html.twig", ["Cinema" => $Cinema]);
     }
}
