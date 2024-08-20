<?php
declare(strict_types=1);

namespace App\Controller;

use App\Message\SendMessage;
use App\Repository\MessageRepository;
use Controller\MessageControllerTest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @see MessageControllerTest
 */
class MessageController extends AbstractController
{
    /**
     * TODO: cover this method with tests, and refactor the code (including other files that need to be refactored)
     */
    #[Route('/messages')]
    public function list(Request $request, MessageRepository $messages): Response
    {
        /**
         * The logic of interacting with the repository should sit inside a ServiceClass, not in the Controller action
         * This way we would have a much cleaner code and distribute the responsibilities based on SOLID principles
         * Here we should have a single line
         * return JsonResponse($service->handleRequest($request), headers: ['Content-Type' => 'application/json']);
         */
        $messages = $messages->by($request); // Not a good way of fetching records from DB. SQL injection's paradise

        foreach ($messages as $key => $message) { // PSR12 tells us to keep a space left and right for the =>
            $messages[$key] = [
                'uuid' => $message->getUuid(),
                'text' => $message->getText(),
                'status' => $message->getStatus(),
            ];
        }
        
        return new Response(json_encode([ // It is better and nicer to use JsonResponse method
            'messages' => $messages,
        ], JSON_THROW_ON_ERROR), headers: ['Content-Type' => 'application/json']);
    }

    #[Route('/messages/send', methods: ['GET'])]
    public function send(Request $request, MessageBusInterface $bus): Response
    {
        $text = $request->query->get('text');
        
        if (!$text) {
            return new Response('Text is required', 400);
        }

        $bus->dispatch(new SendMessage($text));
        
        return new Response('Successfully sent', 204);
    }
}