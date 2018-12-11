<?php

declare(strict_types = 1);

namespace Service\Messanger;

class FacebookService
{
    /* @var string */
    private $apiKey;

    /* @var string */
    private $login;

    /* @var bool */
    private $authenticationStatus = false;

    public function __construct(
        string $login,
        string $apiKey
    ) {
        $this->login = $login;
        $this->apiKey = $apiKey;
    }

    public function authentication(): void
    {
        if ((bool)$this->login && (bool)$this->apiKey) {
            $this->authenticationStatus = true;
            return;
        }
        $this->authenticationStatus = false;
        return;
    }

    public function isAuthenticated(): bool
    {
        return $this->authenticationStatus;
    }

    public function sendMessage(string $message, int $chatId): string
    {
        $message = \strip_tags($message);

        if ($this->isAuthenticated() && (bool)$chatId) {
            return   $message . '`, чат ID: `' . $chatId;
        }

        return 'Please authorize';
    }
}
