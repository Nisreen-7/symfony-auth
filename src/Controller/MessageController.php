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
  public function __construct(private MessageRepository $rep)
  {

  }
  #[Route()]
  public function index(): Response
  {

    return $this->render('message.html.twig', [
      'controller_name' => 'MessageController',
      'message' => $this->rep->findAll(),
    ]);
  }



  #[Route('/add-message')]
  public function addMessage(Request $request): Response
  {
    $formdata = $request->request->all();
    /**
     * @var User
     */
    $user = $this->getUser();

    if (!empty($formdata)) {
      // $message=new Message($formdata['content'],$user->getId());

      $message = new Message($formdata['content'], $user);
      $this->rep->persist($message);
      return $this->redirect('/');
    }
    return $this->render('add-message.html.twig', [
    ]);
  }

  #[Route("/delete-message/{id}")]
  public function removeMessage(int $id): Response
  {
    $message = $this->rep->findById($id);
    /**
     * @var User
     */
    $user = $this->getUser();
    if ($user->getId() == $message?->getUser()->getId()) {
      $this->rep->delete($id);
    }

    return $this->redirect("/");
  }

  #[Route("/forum")]
  public function forum(Request $request)
  {
    $formdata = $request->request->all();
    /**
     * @var User
     */
    $user = $this->getUser();

    if (!empty($formdata)) {
      // $message=new Message($formdata['content'],$user->getId());

      $message = new Message($formdata['content'], $user);
      $this->rep->persist($message);
      return $this->redirect('/');
    }
    return $this->render('forum.html.twig', [
      'message' => $this->rep->findAll(),
    ]);
  }

}