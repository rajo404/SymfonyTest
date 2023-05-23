<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarketController extends AbstractController
{
    #[Route('/market', name: 'market_index')]
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('market/index.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/market/{id}', name: 'market_show')]
    public function show(Team $team): Response
    {
        $playersForSale = $team->getPlayersForSale();

        return $this->render('market/show.html.twig', [
            'team' => $team,
            'playersForSale' => $playersForSale,
        ]);
    }
}
