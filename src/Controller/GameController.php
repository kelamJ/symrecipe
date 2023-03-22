<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{
    /**
     * Ce controller nous permet d'afficher tout les jeux et d'y ajouter une pagination
     *
     * @param GameRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/game', name: 'game.index', methods: ['GET'])]
    public function index(GameRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $games = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/game/index.html.twig', [
            'games' => $games
        ]);
    }

    /**
     * Ce controller nous permet de créer un nouveau jeu
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/game/nouveau', 'game.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ) : Response {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $manager->persist($game);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre jeux a été créé avec succès !'
            );

        return $this->redirectToRoute('game.index');
        }

        return $this->render('pages/game/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
 * Ce controller nous permet de modifier un jeu
 *
 * @param Game $game
 * @param Request $request
 * @param EntityManagerInterface $manager
 * @return Response
 */
#[Route('/game/edition/{id}', 'game.edit', methods: ['GET', 'POST'])]
    public function edit(
        Game $game, 
        Request $request, 
        EntityManagerInterface $manager
        ) : Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $manager->persist($game);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre jeu a été modifié avec succès !'
            );

        return $this->redirectToRoute('game.index');
        }

        return $this->render('pages/game/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Ce controller nous permet de supprimer un jeu
     *
     * @param EntityManagerInterface $manager
     * @param Game $game
     * @return Response
     */
#[Route('/game/suppression/{id}', 'game.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        Game $game
    ) : Response
    {
        $manager->remove($game);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre jeu a été supprimer avec succcès !'
        );

        return $this->redirectToRoute('game.index');
    }
}
