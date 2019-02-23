<?php
define('BASE_DIR', realpath('..'));
require_once('../functions.php');
require_once('../connect.php');

$id = intval($_GET['id']);
$is_auth = rand(0, 1);
$user_name = 'Nika'; // укажите здесь ваше имя

date_default_timezone_set('Europe/Kiev');
$current_date = strtotime('now');
$next_midnight = strtotime('tomorrow');
$interval_hours = date('H:i', ($next_midnight - $current_date));

$query_categories = "select categ_name from categories";
$query_lot = "select l.id, l.date_creation, l.lot_name, l.description, l.image, l.start_price, l.step, l.date_close, c.categ_name
              from lots l
              join categories c on l.category_id = c.id
              where l.id = '$id'";
$query_bets = "select b.id, b.date_bet, b.amount, b.user_id, b.lot_id, u.user_name
              from bets b
              join users u on b.user_id = u.id
              where b.lot_id = '$id'
              order by b.date_bet desc";

$res_categories = mysqli_query($connect, $query_categories);
$res_lot = mysqli_query($connect, $query_lot);
$res_bets = mysqli_query($connect, $query_bets);

$cat_num = mysqli_num_rows($res_categories);
$lot_num = mysqli_num_rows($res_lot);
$bets_num = mysqli_num_rows($res_bets);


if (!$res_lot || !$res_categories || $cat_num == 0) {
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
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

$category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);
$lot = mysqli_fetch_assoc($res_lot);
$bets = mysqli_fetch_all($res_bets, MYSQLI_ASSOC);

if ($lot_num == 0){
  header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
  $page_content = include_template('404.php',['category' => $category]);

}
else {
  $page_content = include_template('lot.php',['category' => $category,
                                              'lot' => $lot,
                                              'bets' => $bets]);
}

 $data = [
        'content' => $page_content,
        'title' => "Главная",
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'category' => $category
    ];
    $html = include_template('layout.php', $data);
    echo $html;