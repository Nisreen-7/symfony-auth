<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    public function __construct(private MessageRepository $rep) {
        
    }
    #[Route('/message')]
    public function index(): Response
    {
       
        return $this->render('message.html.twig', [
            'controller_name' => 'MessageController',
            'message'=> $this->rep->findAll(),
        ]);
    }
    
    #[Route('/add-message')]
    public function addMessage(Request $request): Response
    {
      $formdata=$request->request->all();
      /**
       * @var User
       */
      $user=$this->getUser();

      if(!empty($formdata)){
        $message=new Message($formdata['content'],$user->getId());
        $this->rep->persist($message);
        return $this->redirect('/message');
      }
        return $this->render('add-message.html.twig', [
        ]);
    }
}
