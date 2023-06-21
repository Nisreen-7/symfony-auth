<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route("/register")]
    public function index(UserRepository $rep, Request $request)
    {
        if (!empty($form)) {
            $data = new User($form['email'], $form['password']);
            if($rep->findByEmail($data)){
                $rep->persist($data);
            }else{
                return $this->render("register.html.twig", [
                    'message' => 'Vous avez deja un compte ,Saisir votre compte correct'
                ]); 
            }
           

            // return $this->redirect('/courses/'.$courses->getId());
            return $this->render("register.html.twig", [
                'message' => 'Vous avez inscrir en succes dans notre sit '
            ]);

        }
    }
}