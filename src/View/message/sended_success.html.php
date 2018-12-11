<?php

/** @var Closure @path */
/** @var Closure @renderLayout */
$body = function () use ($path, $data, $social) {
    $data = $data ?? 'Тестовое сообщение';
    echo '<p>
        Вы успешно отправили сообщение: `'
        . $data
        . '`, в соц сеть: `'
        . $social
        . '`</p>';
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Сообщение отправленно',
        'body' => $body,
    ]
);
