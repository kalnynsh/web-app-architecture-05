<?php

declare(strict_types = 1);

namespace Service\Messanger;

use Service\Messanger\IMessanger;

class VKMessanger implements IMessanger
{
    private $clientSicret;
    private $userEmail;
    private $authenticationStatus = false;

    public function __construct(
        string $clientSicret,
        string $userEmail
    ) {
        $this->clientSicret = $clientSicret;
        $this->userEmail = $userEmail;
    }

    public function authentication()
    {
        if ($this->clientSicret && $this->userEmail) {
            $this->authenticationStatus = true;
            return;
        }
        $this->authenticationStatus = false;
        return;
    }

    public function isAuthenticated()
    {
        return $this->authenticationStatus;
    }

    public function send(string $message): string
    {
        $message = strip_tags($message);

        if ($this->isAuthenticated()) {
            return $message;
        }

        return 'Please authorize';
    }
}
