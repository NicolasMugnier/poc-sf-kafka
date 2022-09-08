<?php

namespace App\Transport\Serialization\Message;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class BatchMessageSerializer implements SerializerInterface
{

    public function decode(array $encodedEnvelope): Envelope
    {
        return new Envelope('');
    }

    public function encode(Envelope $envelope): array
    {
        /** @var App\Business\Async\Message\BatchMessage $batchMessage */
        $batchMessage = $envelope->getMessage();
        $headers = array_merge(['content-type' => 'application/json'], $batchMessage->getHeaders());
        return [
            'headers' => $headers,
            'body' => $batchMessage->getBody(),
        ];
    }
}
