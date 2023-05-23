<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Player;
use App\Form\TeamType;
use App\Form\TeamFormType;
use App\Form\PlayerTransferType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/teams', name: 'team_list')]
    public function listTeams(Request $request): Response
    {
        $teams = $this->entityManager->getRepository(Team::class)->findAll();

        return $this->render('team/list.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/teams/new', name: 'team_new')]
    public function newTeam(Request $request): Response
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
        $player->setTeam($team); // Lier le joueur à l'équipe actuelle

        $form = $this->createForm(PlayerTransferType::class, $player);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $buyer = $form->get('buyer')->getData();
            $amount = $form->get('amount')->getData();

            // Implémentez votre logique pour transférer le joueur et mettre à jour les soldes de l'équipe ici

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/transfer.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/teams/{id}', name: 'team_show')]
    public function show(Team $team): Response
    {
        $players = $team->getPlayers();

        return $this->render('team/show.html.twig', [
            'team' => $team,
            'players' => $players,
        ]);
    }

    #[Route('/team/{id}/edit', name:'team_edit')]
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamFormType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/team_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/team/{id}/delete', name:'team_delete', methods:['GET', 'POST'])]
    public function delete(Team $team): Response
    {
        $this->entityManager->remove($team);
        $this->entityManager->flush();

        return $this->redirectToRoute('team_list');
    }
}
