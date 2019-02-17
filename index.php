<?php
define('BASE_DIR', realpath('.'));
require_once('functions.php');

$is_auth = rand(0, 1);

date_default_timezone_set('Europe/Kiev');
$current_date = strtotime('now');
$next_midnight = strtotime('tomorrow');
$interval_hours = date('H:i', ($next_midnight - $current_date));

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
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

$query_lots = "select l.id, l.lot_name, c.categ_name, l.start_price, l.image, l.step
        from lots l
        join categories c on l.category_id = c.id
        where date_format(date_close,'%Y-%m-%d') > date_format(SYSDATE(),'%Y-%m-%d')
        order by date_creation desc
        limit 6";
$query_categories = "select categ_name from categories";

$res_lots = mysqli_query($connect, $query_lots);
$res_categories = mysqli_query($connect, $query_categories);
$cat_num = mysqli_num_rows($res_categories);
$lot_num = mysqli_num_rows($res_lots);

if (!$res_lots || !$res_categories || $cat_num == 0) {
    if ($cat_num == 0) $error = 'Categories quantity is 0.';
    else $error = mysqli_error($connect);
    $page_content = include_template('error.php',['error' => $error]);
    $data = [
        'content' => $page_content,
        'title' => "Главная",
        'is_auth' => $is_auth,
        'user_name' => '',
        'category' => []
    ];
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

$category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);
$lots_list = mysqli_fetch_all($res_lots, MYSQLI_ASSOC);


$user_name = 'Nika'; // укажите здесь ваше имя

$page_content = include_template('index.php',['category' => $category,
                                            'lots_list' => $lots_list,
                                            'interval_hours' => $interval_hours
                                            ]);
$data = [
    'content' => $page_content,
    'title' => "Главная",
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'category' => $category
];
$html = include_template('layout.php', $data);
echo $html;