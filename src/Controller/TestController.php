<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestController extends AbstractController
{

    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/test/hello',name: 'test_hello')]
    public function hello():Response
    {
        $nom='mouhib';
        return $this->render('test/testaffichage.html.twig',[
            'name' =>$nom
        ]);
    }
    



    


}
