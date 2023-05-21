<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route(path:'/profile', name: 'app_profile')]
    public function show()
    {
        return $this->render('dashboard/profile.html.twig');
    }

    #[Route(path:'/profile/update', name:'update_profile')]
    public function update(Request $request)
    {
        // Récupérer les données du formulaire
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // Mettre à jour le profil de l'utilisateur
        // ...

        // Rediriger vers la page de profil ou afficher un message de succès
        // ...

        // Exemple de redirection vers la page de profil
        return $this->redirectToRoute('app_dashboard');
    }

}
