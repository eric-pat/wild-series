<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Service\ProgramDuration;
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
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
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
            $this->addFlash('success', 'La nouvelle série a été créée avec succès !');

            return $this->redirectToRoute('program_index');
        }

        // Rendre le formulaire
        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(
        Program $program,
        ProgramDuration $programDuration):Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'programDuration' => $programDuration->calculate($program),
        ]);
    }

    #[Route('/{programSlug}/seasons/{seasonSlug}', name: 'season_show', methods: ['GET'])]
    #[Entity('program', options: ['mapping' => ['programSlug' => 'slug']])]
    #[Entity('season', options: ['mapping' => ['seasonSlug' => 'slug']])]
    public function showSeason(Program $program,
                               Season $season): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }


    #[Route('/{programSlug}/seasons/{seasonSlug}/episode/{episodeSlug}', name: 'episode_show',methods: ['GET'])]
    #[Entity('program', options: ['mapping'=> ['programId'=>'slug']])]
    #[Entity('season', options: ['mapping'=>['seasonSlug'=>'slug']])]
    #[Entity('episode', options: ['mapping'=>['episodeSlug'=>'slug']])]
    public function showEpisode(Program $program,
                                Season $season,
                                Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }

    #[Route('/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request,
                           Program $program,
                           ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
            $this->addFlash('danger', 'La série a été supprimée avec succès !');
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }

}