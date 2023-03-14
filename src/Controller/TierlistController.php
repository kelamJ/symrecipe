<?php

namespace App\Controller;

use App\Entity\Tierlist;
use App\Form\TierlistType;
use App\Repository\TierlistRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/tierlist', name: 'tierlist.index', methods: ['GET'])]
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

    #[Route('/tierlist/nouveau', 'tierlist.new', methods: ['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager
    ) : Response {
        $tierlist = new Tierlist();
        $form = $this->createForm(TierlistType::class, $tierlist);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $tierlist = $form->getData();

            $manager->persist($tierlist);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre tierlist a été créé avec succès !'
            );

        return $this->redirectToRoute('tierlist.index');
        }

        return $this->render('pages/tierlist/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
