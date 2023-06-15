<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditbookController extends AbstractController
{
    /**
     * @Route("/editbook/{id}", name="app_editbook")
     */
    public function index($id,EntityManagerInterface $manager,Request $request): Response
    {

        $book = $manager->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $book->setCreatedAt(new \DateTime());
            $manager->persist($book);
            $manager->flush();     
            return $this->redirectToRoute('app_single_book',['id' => $book->getId()]);
        }


        return $this->render('editbook/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
