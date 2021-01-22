<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class ApiError
{
    private $status = 'error';
    private $messages = [];

    /**
     * @Groups({"profile", "general"})
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @Groups({"profile", "general"})
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function addError($key, $message)
    {
        $this->messages[][$key] = $message;
    }
}
