<?php

declare(strict_types=1);

namespace App\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

/**
 * @Route(
 *     "/single-message",
 *     name="api_single_message_post",
 *     methods={"POST"}
 * )
 */
class PostSingleMessageController extends AbstractController
{

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function __invoke(Request $request): Response
    {
        $headers = [
            'X-Correlation-ID' => $this->getCorrelationId($request),
            'X-Origin' => $this->getOrigin($request)
        ];
        return JsonResponse::create(['message' => 'success'], 200);
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
