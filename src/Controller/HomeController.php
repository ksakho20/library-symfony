<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $books = $manager->getRepository(Book::class)->findAll();   
        // SELECT * FROM Book
        // findAll() permet de récupérer toute la table 
        //dd($books);
        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }
}
