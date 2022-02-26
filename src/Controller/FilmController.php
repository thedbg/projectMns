<?php

namespace App\Controller;

use App\Entity\Films;
use App\Form\FilmType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
   
    /**
     * @Route("/createfilms", name="create_films")
     * @Route("/updatefilms/{id}", name="update_films")
     */
    public function createfilms(Films $Films = null , Request $request, ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $entityManager = $doctrine->getManager();
        if (!$Films)
        {
            $Films = new Films;
        }
        
        
        $form = $this->createForm(FilmType::class, $Films);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if (!$Films->getId()){
                    $Films->setcreatedAt(new \DateTimeImmutable());
                } 
                    $Films->setupdatedAt(new \DateTime());
                
                $Films = $form->getData();
                $entityManager ->persist($Films);
                $entityManager ->flush();
   
                return $this->redirectToRoute('listingfilms');
            }

        return $this->render('film/Create.html.twig', 
            ['form' => $form->createView(),
             'isEditor' => $Films->getId() ]);
    }

    /**
     * @Route("/listingfilms", name="listingfilms")
     */
    public function listing(ManagerRegistry $doctrine): Response
    {
        $allFilms = $doctrine->getManager()->getRepository(Films::class)->findAll();
        
        
        return $this->render("ListingFilms/ListingFilms.html.twig", 
        ["Films" => $allFilms]);
    }

    
    /**
     * @Route("/deletefilms/{id}", name="delete_films")
     */
    public function delete(ManagerRegistry $doctrine,  $id )
    {
        $entityManager = $doctrine->getManager();
        $film = $entityManager->getRepository(Films::class)->find($id);
        
        if (isset($film)) {
            $entityManager->remove($film);
            $entityManager->flush();
       } 
        return $this->redirectToRoute('listingfilms');
    }

    /**
     * @Route("/descriptionfilms/{id}", name="description_films")
     */
    public function descrition(ManagerRegistry $doctrine, $id )
    {
        $entityManager = $doctrine->getManager();
        $films = $entityManager->getRepository(Films::class)->find($id);
        
        return $this->render('film/description.html.twig', 
        ['Films' => $films ]);
    }
}
