<?php

declare(strict_types = 1);

namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Service\Messanger\VKMessanger;
use Service\Messanger\FacebookService;
use Service\Messanger\FacebookMessanger;
use Framework\Render;

class MessageController
{
    use Render;

    private $messangerService;

    /**
    * @param Request $request
    * @return Response
    */
    public function indexAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $text = $request->request->get('messageBody');
            $messangerName = $request->request->get('messanger');

            if ($messangerName === 'vk') {
                $messanger = $this->getVKMessanger();
            } elseif ($messangerName === 'facebook') {
                $messanger = $this->getFacebookMessanger();
            }

            $this->setMessanger($messanger);
            $data = $this->messangerService->send($text);

            return $this->render(
                'message/sended_success.html.php',
                [
                    'data' => $data,
                    'social' => $messangerName,
                ]
            );
        }

        return $this->render('message/index.html.php');
    }

    private function setMessanger($messanger): void
    {
        $this->messangerService = $messanger;
    }

    private function getFacebookMessanger(
        $login = null,
        $apiKey = null,
        $chartId = null
    ): FacebookMessanger {
        $login = $login ?? 'facebooker911';
        $apiKey = $apiKey ?? \bin2hex(\random_bytes(4));
        $facebooker = new FacebookService($login, $apiKey);

        $facebooker->authentication();
        $chartId = $chartId ?? \random_int(10, 1000);

        return new FacebookMessanger($facebooker, $chartId);
    }

    private function getVKMessanger(
        $clientSicret = null,
        $userEmail = null
    ): VKMessanger {
        $clientSicret = $clientSicret ?? \bin2hex(\random_bytes(4));
        $userEmail = $userEmail ?? 'vk-user@example.com';
        $vkMessanger = new VKMessanger($clientSicret, $userEmail);
        $vkMessanger->authentication();

        return $vkMessanger;
    }
}
