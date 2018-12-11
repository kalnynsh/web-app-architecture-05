<?php

declare(strict_types = 1);

namespace Service\Messanger;

use Service\Messanger\IMessanger;
use Service\Messanger\FacebookService;

/**
 * Adapter class for FacebookService
 */
class FacebookMessanger implements IMessanger
{
    /**
     * FacebookService object
     *
     * @property FacebookService $facebooker
     */
    private $facebooker;

    /**
     * Chat ID
     *
     * @property int|string $chatId
     */
    private $chatId;

    public function __construct(
        FacebookService $facebooker,
        int $chatId
    ) {
        $this->facebooker = $facebooker;
        $this->chatId = $chatId;
    }

    public function send(string $message): string
    {
        $chatId = $this->chatId;

        return $this->facebooker->sendMessage($message, $chatId);
    }
}
