<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SingleBookController extends AbstractController
{
    /**
     * @Route("/single/book/{id}", name="app_single_book")
     */
    public function index($id, EntityManagerInterface $manager): Response
    {
        $book = $manager->getRepository(Book::class)->find($id);
        // find($id) permet de recuperer une ligne de la table (ex: id = 16)
        // il recuperer le livre par son id qui est dans l'url

        // SELECT * FROM book WHERE id = idUrl
        return $this->render('single_book/index.html.twig', [
            'book' => $book,
        ]);
    }



    /**
     * @Route("/single/book/remove/{id}", name="app_single_book_remove")
     */
    public function remove($id, EntityManagerInterface $manager)
    {
        //  0- recuperer l'article en question
        $book = $manager->getRepository(Book::class)->find($id);
        //  1- supprimer l'article en question 
        $manager->remove($book);
        $manager->flush();  
        //  2- redirection sur la page d'accueil
        return $this->redirectToRoute('app_home');

    }
}
