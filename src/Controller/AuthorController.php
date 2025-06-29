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

    #[Route('/showAllAuthors',name:'showAllAuthors')]
    public function showAllAuthors(AuthorRepository $authorRepository): Response
    {
        $authors=$authorRepository->findAll();
        return $this->render('author/showAllAuthors.html.twig', [
            'authors' => $authors
        ]);
    }

    #[Route('/addAuthor', name: 'addAuthor')]
    public function addAuthor(EntityManagerInterface $em,Request $request): Response
    {
        $author=new Author();
        $form=$this->createForm(AuthorForm::class,$author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('showAllAuthors');
        }
        return $this->render('author/addAuthor.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/deleteAuthor/{id}', name: 'deleteAuthor')]
    public function deleteAuthor(int $id, AuthorRepository $authorRepository, EntityManagerInterface $em): Response
    {
        $author=$authorRepository->find($id);
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('showAllAuthors'); 
    }

    #[Route('/editAuthor/{id}', name: 'editAuthor')]
    public function editAuthor(int $id, AuthorRepository $authorRepository, EntityManagerInterface $em, Request $request): Response
    {
        $author=$authorRepository->find($id);
        $form=$this->createForm(AuthorForm::class,$author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('showAllAuthors');
        }
        return $this->render('author/addAuthor.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/authorByEmail/{email}/{username}', name: 'authorByEmail')]
    public function authorByEmail(string $email, string $username, AuthorRepository $authorRepository): Response
    {
        $authors=$authorRepository->findByUsernameAndEmail($username, $email);
        return $this->render('author/authorByEmail.html.twig', [
            'authors' => $authors
        ]);
    }
    



    



}
