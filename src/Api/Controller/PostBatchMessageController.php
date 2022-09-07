<?php

declare(strict_types=1);

namespace App\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Business\Async\Message\BatchMessage;

/**
 * @Route(
 *     "/batch-message",
 *     name="api_batch_message_post",
 *     methods={"POST"}
 * )
 */
class PostBatchMessageController extends AbstractController
{
    /**
     * @var MessageBusInterface $bus
     */
    private $bus;

    public function __construct(
        MessageBusInterface $bus
    ) {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        $this->bus->dispatch((new BatchMessage($request->getContent())));
        return JsonResponse::create('async-operation-id', 202);
    }
}
