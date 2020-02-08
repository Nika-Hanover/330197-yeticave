<?php
$connect = mysqli_connect('localhost', 'chubaka', '2@cnheYltkm#', 'yeticave');
mysqli_set_charset($connect, "utf8");

if($connect === false) {
    $error = "Ошибка подключения: " . mysqli_connect_error();
    $page_content = include_template('error.php',['error' => $error]);
    $data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => []
    ];
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}