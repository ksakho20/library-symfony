<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddBookController extends AbstractController
{
    /**
     * @Route("/addbook", name="app_add_book")
     */
    //Request $request( v dire délégué ses pouvoir à $request)
    public function index(Request $request,EntityManagerInterface $manager): Response
    {
        // Entity Manager permet de gérer les données de la bdd
        // On a importer la class Book
        $book = new Book();

        // On crée un formulaire à partir de la class BookType
        $form = $this->createForm(BookType::class, $book); 
        // On récupère les données du formulaire
        $form->handleRequest($request);

        // On vérifie si le formulaire a été soumis
        if($form->isSubmitted()){
            // Je veux récuperer automatiquement la date courante
            $book->setCreatedAt(new \Datetime('Europe/Paris'));
            // persist permet de préparer les données à être inserér dans la bdd
            $manager->persist($book);
            // On flushe permet d'envoyer les données dans la bdd 
            $manager->flush();
            $this->addFlash('success', 'le livre a bien été ajouté');

            $form = $this->createForm(BookType::class, new Book());
        }


        return $this->render('add_book/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
