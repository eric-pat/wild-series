<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
        ]);
    }

    #[Route('/program/{id}/', name: 'program_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show($id): Response
    {
        // Vérifier si l'ID est un entier
        if (!ctype_digit($id)) {
            throw $this->createNotFoundException();
        }

        return $this->render('program/show.html.twig', [
            'id' => $id,
        ]);
    }

    #[Route('/404', name: 'error_404', methods: ['GET'])]
    public function error404(): Response
    {
        return $this->render('error404.html.twig');
    }
}