<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookForm;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    // Route pour ajouter un nouveau livre
#[Route('/addBook', name: 'add_book')]
public function addBook(EntityManagerInterface $em, Request $request): Response
{
    $book = new Book(); // Crée une nouvelle instance de l'entité Book
    $book->setEnabled(true); // Active le livre par défaut (si vous utilisez un champ booléen "enabled")
    
    $form = $this->createForm(BookForm::class, $book); // Crée un formulaire basé sur la classe BookForm
    $form->handleRequest($request); // Lie les données de la requête HTTP au formulaire

    if ($form->isSubmitted() && $form->isValid()) // Vérifie si le formulaire a été soumis et s’il est valide
    {
        $em->persist($book); // Prépare l'entité Book pour insertion
        $em->flush(); // Exécute l'insertion en base de données
        return $this->redirectToRoute('showAllBooks'); // Redirige vers la liste de tous les livres
    }

    return $this->render('book/addBook.html.twig', [ // Affiche le formulaire si non soumis ou invalide
        'form' => $form->createView()
    ]);
}

// Route pour supprimer un livre par son identifiant
#[Route('/deleteBook/{id}', name: 'deleteBook')]
public function deleteBook(int $id, BookRepository $bookRepository, EntityManagerInterface $em): Response
{
    $book = $bookRepository->find($id); // Recherche le livre par son ID
    $em->remove($book); // Marque le livre pour suppression
    $em->flush(); // Exécute la suppression dans la base de données
    return $this->redirectToRoute('showAllBooks'); // Redirige vers la liste des livres
}

// Route pour modifier un livre existant
#[Route('/editBook/{id}', name: 'editBook')]
public function editBook(int $id, BookRepository $bookRepository, EntityManagerInterface $em, Request $request): Response
{
    $book = $bookRepository->find($id); // Récupère le livre à modifier
    $form = $this->createForm(BookForm::class, $book); // Crée un formulaire pré-rempli avec les données du livre
    $form->handleRequest($request); // Lie les données envoyées au formulaire

    if ($form->isSubmitted() && $form->isValid()) // Vérifie si le formulaire est soumis et valide
    {
        $em->persist($book); // Prépare les modifications à être enregistrées
        $em->flush(); // Enregistre les modifications en base
        return $this->redirectToRoute('showAllBooks'); // Redirige vers la liste des livres
    }

    return $this->render('book/addBook.html.twig', [ // Réutilise le même template que pour l’ajout
        'form' => $form->createView()
    ]);
}


    

    



}
