<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditBookController extends AbstractController
{
    /**
     * @Route("/edit/book", name="app_edit_book")
     */
    public function index($id,Request $request, EntityManagerInterface $manager): Response
    {      

        $book = $manager->getRepository(Book::class)->find($id);
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $book ->setCreatedAt(new \DateTime());
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('edit_book/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
