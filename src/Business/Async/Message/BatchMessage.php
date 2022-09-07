<?php

declare(strict_types=1);

namespace App\Business\Async\Message;

class BatchMessage
{
    /**
     * @var string $message
     */
    private $message;

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
