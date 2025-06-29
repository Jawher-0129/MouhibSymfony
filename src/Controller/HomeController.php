<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home/bonjour',name:'home_bonjour')]
    public function bonjour(): Response
    {
        $message='Bonjour mes étudiants';
        return $this->render('home/bonjour.html.twig', [
            'message' => $message
        ]);
    }

    #[Route('/home/gotoIndex',name:'goto_index')]
    public function gotoIndex(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    

    




}
