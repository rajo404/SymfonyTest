<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Player;
use App\Form\TeamType;
use App\Form\PlayerTransferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class TeamController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route(path:'/teams', name:'team_list')]
    public function listTeams(Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Team::class);
        $teams = $repository->findAll();

        // Filtres
        $countryFilter = $request->query->get('country');

        // Query
        $query = $repository->createQueryBuilder('t')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10 // Number of items per page
        );

        return $this->render('team/list.html.twig', [
            'teams' => $teams,
            'pagination' => $pagination,
        ]);
    }

    #[Route(path:'/teams/new', name:'team_new')]
    public function createTeam(Request $request): Response
    {
        $team = new Team();

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($team);
            $this->entityManager->flush();

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path:'/teams/{team}/transfer', name:'team_transfer')]
    public function transferPlayer(Request $request, Team $team): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerTransferType::class, $player);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $buyer = $form->get('buyer')->getData();
            $amount = $form->get('amount')->getData();

            // Implement your logic for transferring the player and updating team balances here

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/transfer.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }
}
