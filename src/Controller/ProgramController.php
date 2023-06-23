<?php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;
use App\Service\ProgramDuration;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/new', name: 'new')]
    public function new(Request $request,
                        MailerInterface $mailer,
                        ProgramRepository $programRepository,
                        SluggerInterface $slugger): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);

            $program->setOwner($this->getUser());
            $programRepository->save($program, true);

            $email = (new Email())
                ->from('ekcz@orange,fr.com')
                ->to('ekcz@orange,fr.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('program/newProgramEmail.html.twig',
                    ['program' => $program]));

            $mailer->send($email);

            $this->addFlash('success',
                'La nouvelle série a été créée avec succès !');

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

    #[Route('/{programSlug}/seasons/{seasonSlug}/episode/{episodeSlug}', name: 'episode_show',methods: ['GET', 'POST'])]
    #[Entity('program', options: ['mapping'=> ['programSlug'=>'slug']])]
    #[Entity('season', options: ['mapping'=>['seasonSlug'=>'slug']])]
    #[Entity('episode', options: ['mapping'=>['episodeSlug'=>'slug']])]
    public function showEpisode(Program $program,
                                Season $season,
                                Episode $episode,
                                Request $request,
                                CommentRepository $commentRepository,
                                Security $security): Response
    {
        $comment = new Comment();
        $comment->setAuthor($security->getUser());
        $comment->setEpisode($episode);

        $comments = $commentRepository->findBy(
            ['episode' => $episode],
            ['id' => 'ASC']
        );

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $commentRepository->save($comment, true);

            $this->addFlash('success', "Le commentaire a été ajouté avec succès");

            return $this->redirectToRoute('program_season_show', [
                'programSlug' => $program->getSlug(),
                'seasonSlug' => $season->getSlug()
            ], Response::HTTP_SEE_OTHER);

        }

        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
            'form' => $form->createView(),
            'comments' => $comments,
        ]);
    }

    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Program $program,
        ProgramRepository $programRepository,
        SluggerInterface $slugger
    ): Response
    {
        if ($this->getUser() !== $program->getOwner()) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can edit the program!');
        }

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $programRepository->save($program, true);
            $this->addFlash('success', "La série a été mis à jour");

            return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);

    }


    //delete program
    #[Route('/{slug}/delete', name: 'delete', methods: ['POST'])]
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

    //delete comment
    #[Route('/{slug}/comment/delete/{commentId}', name: 'delete_comment', methods: ['POST'])]
    public function deleteComment(Request $request,
                                  $commentId,
                                  CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->find($commentId);

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
            $this->addFlash('danger', 'Le commentaire a été supprimé avec succès !');
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/watchlist', name: 'watchlist', methods: ['GET', 'POST'])]
    public function addToWatchlist(Program $program, UserRepository $userRepository): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with this id found in program\'s table.'
            );
        }

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user->isInWatchlist($program)) {
            $user->removeFromWatchlist($program);
        } else {
            $user->addToWatchlist($program);
        }
        $userRepository->save($user, true);

        return $this->redirectToRoute('program_show', [
            'slug' => $program->getSlug()
        ], Response::HTTP_SEE_OTHER);
    }
}
