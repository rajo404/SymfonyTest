<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(Team $team, Request $request, $id): Response
    {
        $playersForSale = $team->getPlayersForSale();

        // Retrieve the authenticated user
        $user = $this->getUser();

        // Retrieve the user's teams
        $userTeams = $user->getTeams();

        return $this->render('market/show.html.twig', [
            'team' => $team,
            'playersForSale' => $playersForSale,
            'userTeams' => $userTeams,
        ]);
    }

    /**
    * @Route("/buy-player", name="buy_player", methods={"POST"})
    */
    public function buyPlayer(Request $request)
    {
        $playerId = $request->request->get('playerId');
        $price = $request->request->get('price');
        $teamId = $request->request->get('teamId');

        // TODO: Integrate the player into the selected team with the provided price

        // Redirect the user to a confirmation page or the updated market page
        return $this->redirectToRoute('market_show', ['id' => $teamId]);
    }
}
