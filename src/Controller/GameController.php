<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{
    /**
     * Ce controller affiche tout les jeux
     *
     * @param GameRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/jeux', name: 'game.index', methods: ['GET'])]
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
}
