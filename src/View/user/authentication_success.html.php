<?php

/** @var \Model\Entity\User $user */
$body = function () use ($path, $user) {
    echo '<p>Вы успешно авторизовались под логином: '. $user->getLogin() . '</p>';
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Авторизация',
        'body' => $body,
    ]
);
