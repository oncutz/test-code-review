<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;

readonly class MessageService
{
    public function __construct(private MessageRepository $messagesRepository)
    {
    }

    /**
     * @param Request $request
     * @return array<Message|array<string, string|null>>
     */
    public function getMessages(Request $request): array
    {
        $messages = $this->messagesRepository->by($request);

        foreach ($messages as $key => $message) {
            $messages[$key] = [
                'uuid' => $message->getUuid(),
                'text' => $message->getText(),
                'status' => $message->getStatus(),
            ];
        }

        return $messages;
    }
}