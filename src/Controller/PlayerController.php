<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Form\PlayerFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlayerController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/players', name: 'player_list')]
    public function listPlayers(): Response
    {
        $players = $this->entityManager->getRepository(Player::class)->findAll();

        return $this->render('player/list.html.twig', [
            'players' => $players,
        ]);
    }

    #[Route('/players/new', name: 'player_new')]
    public function newPlayer(Request $request): Response
    {
        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($player);
            $this->entityManager->flush();

            return $this->redirectToRoute('player_list');
        }

        return $this->render('player/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/players/{id}/buy', name: 'player_buy')]
    public function buyPlayer(Player $player): Response
    {
        // Logique pour acheter un joueur

        return $this->redirectToRoute('player_list');
    }

    #[Route('/players/{id}/sell', name: 'player_sell')]
    public function sellPlayer(Player $player): Response
    {
        // Logique pour vendre un joueur

        return $this->redirectToRoute('player_list');
    }

    #[Route('/players/{id}', name: 'player_show')]
    public function show(Player $player): Response
    {
        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }

    #[Route('/players/{id}/edit', name: 'player_edit')]
    public function edit(Request $request, Player $player): Response
    {
        $form = $this->createForm(PlayerFormType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('player_list');
        }

        return $this->render('player/player_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/players/{id}/delete', name: 'player_delete', methods: ['GET', 'POST'])]
    public function delete(Player $player): Response
    {
        $this->entityManager->remove($player);
        $this->entityManager->flush();

        return $this->redirectToRoute('player_list');
    }
}
