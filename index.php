<?php
define('BASE_DIR', realpath('.'));
define('BASE_ADDRESS', '/YetiCave/330197-yeticave');
require_once('functions.php');
require_once('connect.php');
session_start();

$user_name = $_SESSION['user']['user_name'] ?? ''; // укажите здесь ваше имя

date_default_timezone_set('Europe/Kiev');
$current_date = strtotime('now');

$query_lots = "select l.id, l.lot_name, c.categ_name, l.start_price, l.image, l.step, l.date_close
        from lots l
        join categories c on l.category_id = c.id
        /*where date_format(date_close,'%Y-%m-%d') > date_format(SYSDATE(),'%Y-%m-%d')*/
        order by l.date_creation desc
        limit 6";
$query_categories = "select categ_name from categories";

$res_lots = mysqli_query($connect, $query_lots);
$res_categories = mysqli_query($connect, $query_categories);
$cat_num = mysqli_num_rows($res_categories);
$lot_num = mysqli_num_rows($res_lots);

if (!$res_lots || !$res_categories || $cat_num === 0) {
    if ($cat_num === 0){
        $error = 'Categories quantity is 0.';
    }
    else {
        $error = mysqli_error($connect);
    }
    $page_content = include_template('error.php',['error' => $error]);
    $data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => '',
        'category' => []
    ];
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

$category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);
$lots_list = mysqli_fetch_all($res_lots, MYSQLI_ASSOC);

$page_content = include_template('index.php',['category' => $category,
                                            'lots_list' => $lots_list
                                            ]);
$data = [
    'content' => $page_content,
    'title' => "Главная",
    'user_name' => $user_name,
    'category' => $category
];

$html = include_template('layout.php', $data);
echo $html;