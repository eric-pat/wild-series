<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        ProgramRepository $programRepository,
        CategoryRepository $categoryRepository
    ): Response
    {
        $programs = $programRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request,
                        ProgramRepository $programRepository,
                        SluggerInterface $slugger): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program, [
            'attr' => [
                'enctype' => 'multipart/form-data',
            ],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier téléchargé
            $posterFile = $form->get('poster')->getData();

            // Générer un nouveau nom pour l'image en utilisant le slugger
            $originalFileName = pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = $slugger->slug($originalFileName);
            $newFileName = $safeFileName.'.'.$posterFile->guessExtension();

            // Déplacer le fichier vers le dossier souhaité
            $posterFile->move(
                '/Users/eric-pat/Desktop/wild-series/public/images/poster',
                $newFileName
            );

            $program->setPosterPath($newFileName);

            // Enregistrer l'entité en base de données
            $programRepository->save($program, true);

            return $this->redirectToRoute('program_index');
        }

        // Rendre le formulaire
        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Program $program):Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', name: 'season_show',methods: ['get'])]
    #[Entity('program', options: ['mapping'=> ['programId'=>'id']])]
    #[Entity('season', options: ['mapping'=>['seasonId'=>'id']])]
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}/episode/{episodeId}', name: 'episode_show',methods: ['get'])]
    #[Entity('program', options: ['mapping'=> ['programId'=>'id']])]
    #[Entity('season', options: ['mapping'=>['seasonId'=>'id']])]
    #[Entity('episode', options: ['mapping'=>['episodeId'=>'id']])]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}