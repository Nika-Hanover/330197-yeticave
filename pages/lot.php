<?php
define('BASE_DIR', realpath('..'));
require_once('../functions.php');
require_once('../connect.php');
session_start();

$user_name = $_SESSION['user']['user_name'] ?? '';
$user_id = $_SESSION['user']['id'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : '';

date_default_timezone_set('Europe/Kiev');

$query_categories = "select categ_name from categories";
$query_lot = "select l.id, l.date_creation, l.lot_name, l.description, l.image, l.start_price, l.step, l.current_price, l.date_close, c.categ_name, l.author_id
              from lots l
              join categories c on l.category_id = c.id
              where l.id = '$id'";
$query_bets = "select b.id, b.date_bet, b.amount, b.user_id, b.lot_id, u.user_name
              from bets b
              join users u on b.user_id = u.id
              where b.lot_id = '$id'
              order by b.date_bet desc";
$query__user_bets = "select distinct b.user_id
                     from bets b
                     where b.lot_id = '$id' and b.user_id = '$user_id'";

$res_categories = mysqli_query($connect, $query_categories);
$res_lot = mysqli_query($connect, $query_lot);
$res_bets = mysqli_query($connect, $query_bets);
$res_user_bets = mysqli_query($connect, $query__user_bets);

$cat_num = mysqli_num_rows($res_categories);
$lot_num = mysqli_num_rows($res_lot);
$bets_num = mysqli_num_rows($res_bets);
$user_bets = mysqli_num_rows($res_user_bets);

if (!$res_lot || !$res_categories || $cat_num === 0) {
    if ($cat_num === 0){
         $error = 'Categories quantity is 0.';
    }
    else{
        $error = mysqli_error($connect);
    } 
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

$category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);
$lot = mysqli_fetch_assoc($res_lot);
$bets = mysqli_fetch_all($res_bets, MYSQLI_ASSOC);

$min_bet = ($lot['current_price'] ?? $lot['start_price']) + $lot['step'];
$interval_hours = interval_date($lot['date_close']);

if ($lot_num === 0){
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $page_content = include_template('404.php',['category' => $category]);
    $data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => $category
    ];
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $bet = $_POST;
    $required_field = ['cost'];
    $errors = [];
    $user_id = $_SESSION['user']['id']; 
    $lot_id = $id;
    

    if(!isset($_SESSION['user'])){
        $error = "Время сессии истекло. Войдите на сайт и сделайте Вашу ставку.";
        $page_content = include_template('error.php',['error' => $error]);
        $data = [
              'content' => $page_content,
              'title' => "Главная",
              'user_name' => $user_name,
              'category' => []
        ];
        header($_SERVER['SERVER_PROTOCOL']." 401 Unauthorized");
        $html = include_template('layout.php', $data);
        echo $html;
        exit();
    }

    // Do validation form, text of errors save in array $errors
    foreach($required_field as $field){
        if(empty($bet[$field])){
            $errors[$field] = "Заполните поле";
        }
    }

    if(isset($bet['cost']) && (!is_numeric($bet['cost']) || intval($bet['cost']) < $min_bet)){
        $errors['cost'] = "Минимальная ставка ".price_format($min_bet);
    }

    if(count($errors) > 0){
        $page_content = include_template('lot.php',['category' => $category ,
                                                    'lot' => $lot,
                                                    'interval_hours' => $interval_hours,
                                                    'min_bet' => $min_bet,
                                                    'bets' => $bets,
                                                    'user_bets' => $user_bets,
                                                    'errors' => $errors
                                                ]);
        $data = [
                'content' => $page_content,
                'title' => "Главная",
                'user_name' => $user_name,
                'category' => $category
        ];
        $html = include_template('layout.php', $data);
        echo $html;
        exit();
    }
        $sql = 'insert into bets (amount, user_id, lot_id)
            values (?,?,?)';

        $stmt = db_get_prepare_stmt($connect, $sql, [
                strip_tags($bet['cost']), 
                intval($user_id),
                intval($lot_id)
        ]);
        mysqli_stmt_execute($stmt);

        $sql_update = 'update lots l set l.current_price = (select max(amount) max_amount from bets b where l.id = b.lot_id) where l.id = (?)';

        $stmt_update = db_get_prepare_stmt($connect, $sql_update, [
                intval($lot_id)
        ]);
        mysqli_stmt_execute($stmt_update);

        header("Location: /pages/lot.php?id=".$id);
        exit();
}
$page_content = include_template('lot.php',['category' => $category,
                                            'lot' => $lot,
                                            'min_bet' => $min_bet,
                                            'interval_hours' => $interval_hours,
                                            'bets' => $bets,
                                            'user_bets' => $user_bets]);
$data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => $category
    ];
$html = include_template('layout.php', $data);
echo $html;