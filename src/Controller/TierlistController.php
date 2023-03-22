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
     * Ce controller nous permet d'afficher toutes les tierlist et d'y ajouter une pagination
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

    /**
     * Ce controller nous permet de créer une nouvelle tierlist
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/tierlist/nouveau', 'tierlist.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
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


    
    /**
     * Ce controller nous permet de modifier une tierlist
     *
     * @param Tierlist $tierlist
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('tierlist/edition/{id}', 'tierlist.edit', methods: ['GET', 'POST'])]
    public function edit(
        Tierlist $tierlist, 
        Request $request, 
        EntityManagerInterface $manager
        ) : Response
    {
        $form = $this->createForm(TierlistType::class, $tierlist);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $tierlist = $form->getData();

            $manager->persist($tierlist);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre tierlist a été modifié avec succès !'
            );

        return $this->redirectToRoute('tierlist.index');
        }

        return $this->render('pages/tierlist/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
 *  Ce controller nous permet de supprimer une tierlist
 *
 * @param EntityManagerInterface $manager
 * @param Tierlist $tierlist
 * @return Response
 */
#[Route('/tierlist/suppression/{id}', 'tierlist.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager, 
        Tierlist $tierlist
        ) : Response
    {
        $manager->remove($tierlist);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre tierlist a été modifié avec succès !'
        );

        return $this->redirectToRoute('tierlist.index');
    }
}
