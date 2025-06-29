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


    #[Route('/showAllBooks', name: 'showAllBooks')]
    public function showAllBooks(BookRepository $repo): Response
    {
        $book=$repo->findAll();
        return $this->render('book/showAllBooks.html.twig', [
            'books' => $book
        ]);
    }

    #[Route('/addBook', name: 'add_book')]
    public function addBook(EntityManagerInterface $em,Request $request): Response
    {
        $book=new Book();
        $book->setEnabled(true);
        $form=$this->createForm(BookForm::class,$book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('showAllBooks');
        }
        return $this->render('book/addBook.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/deleteBook/{id}', name: 'deleteBook')]
    public function deleteBook(int $id, BookRepository $bookRepository, EntityManagerInterface $em): Response
    {
        $book=$bookRepository->find($id);
        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute('showAllBooks');
    }

    #[Route('/editBook/{id}', name: 'editBook')]
    public function editBook(int $id, BookRepository $bookRepository, EntityManagerInterface $em, Request $request): Response
    {
        $book=$bookRepository->find($id);
        $form=$this->createForm(BookForm::class,$book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('showAllBooks');
        }
        return $this->render('book/addBook.html.twig', [
            'form' => $form->createView()
        ]);
    }

    

    



}
