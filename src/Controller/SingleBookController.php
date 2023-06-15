<?php

namespace App\Controller;

use App\Entity\Book;
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
        // Récupérer le livre correspondant à son ID
        $book = $manager->getRepository(Book::class)->find($id);

        return $this->render('single_book/index.html.twig', [
            'book' => $book,
        ]);
    }


    /**
     * @Route("/single/book/remove/{id}", name="app_single_book_remove")
     */
    public function remove($id, EntityManagerInterface $manager)
    {
        // 1- Récupérer le livre à supprimer
        $book = $manager->getRepository(Book::class)->find($id);

        // if (!$book) {
        //     throw $this->createNotFoundException('Le livre avec l\'ID ' . $id . ' n\'existe pas.');
        // }

        // 2- Supprimer le livre
        $manager->remove($book);
        $manager->flush();

        // 3- Redirection sur la page d'accueil
        return $this->redirectToRoute('app_home');
    }
}
