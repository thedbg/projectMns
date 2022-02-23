<?php

namespace App\Controller;

use App\Entity\Films;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
   
    /**
     * @Route("/create_films", name="create_films")
     */
    public function create_films(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $Films = new Films;
        $Films->setTitle(' Spider-man');
        $Films->setRealisator("Marvel");
        $Films->setGenre('Action');
        // tell Doctrine you want to (eventually) save the Films (no queries yet)
        $entityManager->persist($Films);
         // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        
        return new Response('Un nouveau Film a été crée : ' . $Films->getTitle());

    }

    /**
     * @Route("/listingfilms", name="listingfilms")
     */
    public function listing(ManagerRegistry $doctrine): Response
    {
        $Films = $doctrine->getManager()->getRepository(Films::class)->findAll();
        
        
        
        return new Response('Check out this great product: '.$Films->getTitle());
    }
    
}
