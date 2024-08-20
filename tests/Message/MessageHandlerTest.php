<?php

namespace App\Tests\Message;

use App\Message\SendMessage;
use App\Message\SendMessageHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MessageHandlerTest extends TestCase
{
    private MockObject $entityManager;
    private SendMessageHandler $handler;

    protected function setUp(): void
    {
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->handler = new SendMessageHandler($this->entityManager);
    }

    /**
     * @test
     */
    public function willDispatchAnewMessages(): void
    {
        $message = new SendMessage('test');

        $this->entityManager->expects(self::exactly(1))
            ->method('persist');

        $this->entityManager->expects(self::exactly(1))
            ->method('flush');

        $handler = $this->handler;
        $handler($message);
    }
}
