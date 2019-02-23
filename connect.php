<?php
$connect = mysqli_connect('localhost', 'root', '', 'yeticave');

if($connect == false) {
    $error = "Ошибка подключения: " . mysqli_connect_error();
    $page_content = include_template('error.php',['error' => $error]);
    $data = [
        'content' => $page_content,
        'title' => "Главная",
        'is_auth' => $is_auth,
        'user_name' => '',
        'category' => []
    ];
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}