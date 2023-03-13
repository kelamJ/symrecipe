<?php

namespace App\Controller;

use App\Repository\TierlistRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TierlistController extends AbstractController
{
    /**
     * Cette fonction affiche toutes les tierlist
     *
     * @param TierlistRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/tierlist', name: 'tierlist', methods: ['GET'])]
    public function index(TierlistRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $tierlists = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/tierlist/index.html.twig', [
            'tierlists' => $tierlists
        ]);
    }
}
