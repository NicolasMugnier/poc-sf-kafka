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
use Psr\Log\LoggerInterface;

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

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    public function __construct(
        MessageBusInterface $bus,
        LoggerInterface $logger
    ) {
        $this->bus = $bus;
        $this->logger = $logger;
    }

    public function __invoke(Request $request): Response
    {
        $headers = [
            'X-Correlation-ID' => $this->getCorrelationId($request),
            'X-Origin' => $this->getOrigin($request)
        ];
        try {
            $this->bus->dispatch((new BatchMessage($headers, $request->getContent())));
        } catch (\Symfony\Component\Messenger\Exception\TransportException $exception) {
            $logMessage = 'Brokers unreachable, ' . $headers['X-Correlation-ID'] . ', ' . $headers['X-Origin'] . ', ' . json_encode($request->getContent());
            $this->logger->error($logMessage);
            return JsonResponse::create(['error' => ['message' => 'An error occured']], 500);
        }
        return JsonResponse::create(['asyncOperationId' => uniqid()], 202);
    }

    private function getCorrelationId(Request $request): string
    {
        return $request->headers->get('X-Correlation-ID') ?? uniqid();
    }

    private function getOrigin(Request $request): string
    {
        return $request->headers->get('X-Origin') ?? '';
    }
}
