<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AddBookController extends AbstractController
{
    /**
     * @Route("/addbook", name="app_addbook")
     */
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brochureFile = $form->get('picture')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si quelque chose se passe pendant le téléchargement du fichier
                    throw new \Exception('Une erreur s\'est produite lors du téléchargement du fichier.');
                }

                $book->setBrochureFilename($newFilename);
            }

            return $this->redirectToRoute('app_addbook');
        }

        return $this->render('addbook/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function new(Request $request, FileUploader $fileUploader)
{
    // ...
    $book= new Book;
    $form = $this->createForm(BookType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

        /** @var UploadedFile $brochureFile */
        $brochureFile = $form->get('brochure')->getData();
        if ($form->get('brochure')->getData()) {
            $brochureFileName = $fileUploader->upload($form->get('brochure')->getData());
            $book->setBrochureFilename($brochureFileName);
        }

        // ...
    }

    // ...
}
    
}
