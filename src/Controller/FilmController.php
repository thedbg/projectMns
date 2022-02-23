<?php

namespace App\Controller;

use App\Entity\Films;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmController extends AbstractController
{
   
    /**
     * @Route("/createfilms", name="create_films")
     * @Route("/updatefilms/{id}", name="update_films")
     */
    public function createfilms(Request $request, ManagerRegistry $doctrine, $id = null)
    {
        $entityManager = $doctrine->getManager();
        $isEditor = false;

        if (isset($id))
        {
            $Films = $entityManager->getRepository(Films::class)->find($id);
            $isEditor = true;
                if (!isset($Films)) 
                    {
                        return $this->redirectToRoute('listingfilms');
                    }
        }   else 
            {
                $Films = new Films;
            }
        
        
        $form = $this->createFormBuilder($Films)
            ->add('Title', TextType::class)
            ->add('Realisator',TextType::class)
            ->add('Genre', TextType::class)
            ->add('Description', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $Films = $form->getData();

                $entityManager ->persist($Films);
                $entityManager ->flush();
   
                // ... perform some action, such as saving the task to the database
    
                return $this->redirectToRoute('listingfilms');
            }

        return $this->render('film/Create.html.twig', 
            ['form' => $form->createView(),
             'isEditor' => $isEditor ]);
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
