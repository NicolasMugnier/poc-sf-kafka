<?php

declare(strict_types=1);

namespace App\Business\Async\Message;

class BatchMessage
{
    /**
     * @var string $message
     */
    private $message;

    /**
     * @var array<string, string> $headers
     */
    private $headers;

    public function __construct(array $headers, string $message)
    {
        $this->headers = $headers;
        $this->message = $message;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return $this->message;
    }
}
