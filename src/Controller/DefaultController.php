<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        ProgramRepository $programRepository
    ): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('/index.html.twig', [
            'programs' => $programs,
        ]);
    }


    #[Route('/404', name: 'error_404', methods: ['GET'])]
    public function error404(): Response
    {
        return $this->render('error404.html.twig');
    }
}

