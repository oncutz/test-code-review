<?php
declare(strict_types=1);

namespace App\Controller;

use App\Message\SendMessage;
use App\Service\MessageService;
use Controller\MessageControllerTest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @see MessageControllerTest
 */
class MessageController extends AbstractController
{
    #[Route('/messages')]
    public function list(Request $request, MessageService $messageService): Response
    {
        $data = $messageService->getMessages($request);
        
        return new JsonResponse($data);
    }

    #[Route('/messages/send', methods: ['GET'])]
    public function send(Request $request, MessageBusInterface $bus): Response
    {
        $text = $request->query->get('text');
        
        if (!$text || !is_string($text)) {
            return new Response('Text is required', 400);
        }

        $bus->dispatch(new SendMessage($text));
        
        return new Response('Successfully sent', 204);
    }
}