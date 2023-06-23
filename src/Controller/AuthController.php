<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route("/register")]
    public function register(UserRepository $rep, Request $request, UserPasswordHasherInterface $hasher)
    {
        $errors = [];
        $form = $request->request->all();

        if (!empty($form)) {
            $user = new User($form['email'], $form['password']);

            if ($user->getPassword() != $form['repassword']) {
                $errors[] = 'Vous avez pas saisir le même password,Refaire SVP!';
            }

            if ($rep->findByEmail($user->getEmail())) {
                $errors[] = 'Vous avez dèja un compte,allez sur le page Login';
            }

            if (count($errors) == 0) {
                $hash = $hasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hash);
                $rep->persist($user);
                return $this->render("register.html.twig", [
                    'message' => 'Votre inscription est bien registré'
                ]);
            }

        }

        return $this->render("register.html.twig", [
            'errors' => $errors
        ]);
    }



    #[Route("/login")]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastEmail = $authenticationUtils->getLastUsername();
        return $this->render('login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error,
        ]);
    }

    #[Route("/Protected")]
    public function protected ()
    {
        return $this->render('Protected.html.twig', [

        ]);
    }

}