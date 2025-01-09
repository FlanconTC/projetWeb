<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagerieController extends AbstractController
{
    #[Route('/messagerie', name: 'app_messagerie')]
    public function index(MessageRepository $messageRepository): Response
    {
        $user = $this->getUser();
        
        // Récupérer toutes les conversations pour l'utilisateur actuel
        $conversations = $messageRepository->findConversationsByUser($user);
        
        return $this->render('messagerie/index.html.twig', [
            'conversations' => $conversations,
        ]);
    }

    #[Route('/messagerie/conversation/{id}', name: 'app_messagerie_conversation')]
    public function conversation(int $id, MessageRepository $messageRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $receiver = $userRepository->find($id);

        if (!$receiver) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Récupérer tous les messages de la conversation
        $messages = $messageRepository->findMessagesByConversation($user, $receiver);

        return $this->render('messagerie/conversation.html.twig', [
            'messages' => $messages,
            'recipientId' => $receiver->getId(),
        ]);
    }

    #[Route('/messagerie/send', name: 'app_messagerie_send', methods: ['POST'])]
    public function sendMessage(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $sender = $this->getUser();
        $recipientId = $request->request->get('recipient_id');
        $content = $request->request->get('content');

        $receiver = $userRepository->find($recipientId);

        if (!$receiver) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        // Créer et sauvegarder un nouveau message
        $message = new Message();
        $message->setSender($sender)
                ->setReceiver($receiver)
                ->setContent($content)
                ->setCreatedAt(new \DateTimeImmutable());

        $em->persist($message);
        $em->flush();

        return $this->redirectToRoute('app_messagerie_conversation', ['id' => $recipientId]);
    }
}

