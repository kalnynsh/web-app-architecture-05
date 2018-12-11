<?php

/** @var Closure $path */
/** @var Closure $renderLayout */
$body = function () use ($path) {
?>
<div>
    <br/><br/>
    <form action="" method="post">
        <label for="textInput">Введите сообщение</label>
        <input id="textInput" name="messageBody" type="text" value="" />
        <br/><br/>
        <label for="getMessanger">Выберити соцсеть</label>
        <select id="getMessanger" name="messanger">
            <option value="vk" selected>VK</option>
            <option value="facebook">Facebook</option>
        </select>
        <br/><br/>
        <input type="submit" value="Отправить сообщение" />
    </form>
    <br/>
    <br/>
</div>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Сообщения',
        'body' => $body,
    ]
);
