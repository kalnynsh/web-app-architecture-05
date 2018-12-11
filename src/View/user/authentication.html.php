<?php

/** @var Closure $path */
/** @var Closure $renderLayout */
$body = function () use ($path, $error) {
?>
    <form action="<?= $path('user_authentication') ?>" method="post">
        Логин: <input name="login" type="text" /><br /><br />
        Пароль: <input name="password" type="password" /><br /><br />
        <input type="submit" value="Войти" />
    </form>
    <?= $error ?>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Авторизация',
        'body' => $body,
    ]
);
