<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route("/register")]
    public function index(UserRepository $rep, Request $request, UserPasswordHasherInterface $interface)
    {
        $form = $request->request->all();
        if (!empty($form)) {
            $data = new User($form['email'], $form['password'], $form['repassword']);

            if ($form['password'] != $form['repassword']) {
                return $this->render("register.html.twig", [
                    'message' => 'Vous avez pas saisir le même password'
                ]);
            }
            if (!$rep->findByEmail($data->getEmail())) {
                $hashed = $interface->hashPassword($data, $form['password']);
                $data->setPassword($hashed);
                $rep->persist($data);
                return $this->render("register.html.twig", [
                    'message' => 'Vous avez inscrire en success'
                ]);

            } else {
                return $this->render("register.html.twig", [
                    'message' => 'Vous avez deja un compte ,Saisir votre compte correct'
                ]);
            }

        }

        return $this->render("register.html.twig", [

        ]);
    }
}