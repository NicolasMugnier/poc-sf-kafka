<?php

declare(strict_types=1);

namespace App\Business\Async\Message;

class BatchMessage
{
    private string $message;

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
