<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorForm;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }


    #[Route('/listAuthors', name: 'list_authors')]
    public function listAuthors(): Response
    {
        $authors = array(
    array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
    array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
    array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
    );
    return $this->render('author/list.html.twig', [
        'authors' => $authors
    ]);
    }


    #[Route('/authorDetails/{id}', name: 'author_details')]
    public function authorDetails(int $id): Response
    {
            $authors = array(
    array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
    array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
    array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
    );

    return $this->render('author/details_author.html.twig', [
        'author' => $authors[$id - 1]
    ]);
    }
// Route pour afficher tous les auteurs
#[Route('/showAllAuthors', name: 'showAllAuthors')]
public function showAllAuthors(AuthorRepository $authorRepository): Response
{
    $authors = $authorRepository->findAll(); // Récupère tous les auteurs depuis la base de données
    return $this->render('author/showAllAuthors.html.twig', [ // Rend la vue Twig avec la liste des auteurs
        'authors' => $authors
    ]);
}

// Route pour ajouter un nouvel auteur
#[Route('/addAuthor', name: 'addAuthor')]
public function addAuthor(EntityManagerInterface $em, Request $request): Response
{
    $author = new Author(); // Crée une nouvelle instance de l'entité Author
    $form = $this->createForm(AuthorForm::class, $author); // Crée un formulaire basé sur AuthorForm et lié à $author
    $form->handleRequest($request); // Traite la requête HTTP et remplit le formulaire

    if ($form->isSubmitted() && $form->isValid()) // Vérifie si le formulaire est soumis et valide
    {
        $em->persist($author); // Prépare l'entité Author à être enregistrée
        $em->flush(); // Exécute l'insertion dans la base de données
        return $this->redirectToRoute('showAllAuthors'); // Redirige vers la liste des auteurs
    }

    return $this->render('author/addAuthor.html.twig', [ // Affiche le formulaire si non soumis ou invalide
        'form' => $form->createView()
    ]);
}

// Route pour supprimer un auteur par son identifiant
#[Route('/deleteAuthor/{id}', name: 'deleteAuthor')]
public function deleteAuthor(int $id, AuthorRepository $authorRepository, EntityManagerInterface $em): Response
{
    $author = $authorRepository->find($id); // Recherche l’auteur par son id
    $em->remove($author); // Marque l’auteur pour suppression
    $em->flush(); // Exécute la suppression dans la base de données
    return $this->redirectToRoute('showAllAuthors'); // Redirige vers la liste des auteurs
}

// Route pour modifier un auteur existant
#[Route('/editAuthor/{id}', name: 'editAuthor')]
public function editAuthor(int $id, AuthorRepository $authorRepository, EntityManagerInterface $em, Request $request): Response
{
    $author = $authorRepository->find($id); // Recherche l’auteur à modifier
    $form = $this->createForm(AuthorForm::class, $author); // Crée un formulaire prérempli avec les données de l’auteur
    $form->handleRequest($request); // Traite la requête HTTP et remplit le formulaire

    if ($form->isSubmitted() && $form->isValid()) // Vérifie si le formulaire est soumis et valide
    {
        $em->persist($author); // Prépare l’auteur modifié à être enregistré
        $em->flush(); // Enregistre les modifications dans la base
        return $this->redirectToRoute('showAllAuthors'); // Redirige vers la liste des auteurs
    }

    return $this->render('author/addAuthor.html.twig', [ // Réutilise le même template que pour l'ajout
        'form' => $form->createView()
    ]);
}

// Route pour afficher les auteurs correspondant à un email et un username donnés
#[Route('/authorByEmail/{email}/{username}', name: 'authorByEmail')]
public function authorByEmail(string $email, string $username, AuthorRepository $authorRepository): Response
{
    $authors = $authorRepository->findByUsernameAndEmail($username, $email); // Récupère les auteurs correspondants au username et à l’email
    return $this->render('author/authorByEmail.html.twig', [ // Rend la vue avec les auteurs trouvés
        'authors' => $authors
    ]);
}

    



    



}
