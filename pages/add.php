<?php
define('BASE_DIR', realpath('..'));
define('BASE_ADDRESS', '/YetiCave/330197-yeticave');
require_once('../functions.php');
require_once('../connect.php');
session_start();

$user_name = $_SESSION['user']['user_name'] ?? '';
$user_id = $_SESSION['user']['id'] ?? '';
date_default_timezone_set('Europe/Kiev');
$current_date = strtotime('now');
$min_date = strtotime('tomorrow');
$max_date = strtotime('+1 year');
$file_url = "";

/*Variables for saving data from submited form*/
$lot_name = $_POST['lot-name'] ?? '';
$category_id = $_POST['category'] ?? '';
$message = $_POST['message'] ?? '';
$lot_rate = $_POST['lot-rate'] ?? '';
$lot_step = $_POST['lot-step'] ?? '';
$lot_date = $_POST['lot-date'] ?? '';

$query_categories = "select id, categ_name from categories";

$res_categories = mysqli_query($connect, $query_categories);

$cat_num = mysqli_num_rows($res_categories);

if (!$res_categories || $cat_num === 0) {
    if ($cat_num === 0) {
        $error = 'Categories quantity is 0.';
    } 
    else {
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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $lot = $_POST;
    $required_field = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $errors = [];
    $max_text = 255; 
    $max_textarea = 2000;

    // Do validation form, text of errors save in array $errors
    foreach($required_field as $field){
        if(empty($lot[$field])){
            $errors[$field] = "Заполните поле";
        }
    }

    if(isset($lot['lot-name']) && mb_strlen($lot['lot-name']) > $max_text){
        $errors['lot-name'] = "Максимальное количество символов 255";
    }
    if(isset($lot['message']) && mb_strlen($lot['message']) >$max_textarea){
        $errors['message'] = "Максимальное количество символов 2000";
    }
    if(isset($lot['lot-rate']) && (!is_numeric($lot['lot-rate']) || intval($lot['lot-rate']) <= 0)){
        $errors['lot-rate'] = "Введите число больше нуля";
    }
    if(isset($lot['lot-step']) && (!is_numeric($lot['lot-step']) || intval($lot['lot-step']) <= 0)){
        $errors['lot-step'] = "Введите число больше нуля";
    }
    if(isset($lot['lot-date']) && (strtotime($lot['lot-date']) < $min_date || strtotime($lot['lot-date']) > $max_date)) {
        $errors['lot-date'] = "Выберите срок размещения лота от 1 до 365 дней";
    }

    if(isset($_FILES['photo2'])){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_name = $_FILES['photo2']['tmp_name'];
        $file_size = $_FILES['photo2']['size'];
        $file_type = finfo_file($finfo, $file_name);
        $file_path = BASE_DIR.'/img/uploaded_lots/';
        $file_url = '/img/uploaded_lots/';

        if ($file_type === 'image/png') {
            $file_name = uniqid().'.png';
        }
        elseif ($file_type === 'image/jpeg') {
            $file_name = uniqid().'.jpeg';
        }
        // if($file_type !== 'image/png' && $file_type !== 'image/jpeg'){
        else{
            $errors['photo2'] = "Загрузите картинку в одном из форматов: .png, .jpg, .jpeg";
            $file_name = "";
            $file_url = "";
        }
        if ($file_size > 2000000) {
            $errors['photo2'] = "Загрузите файл не больше 2Мб";
            $file_name = "";
            $file_url = "";
        }
        $file_url = $file_url.$file_name;
    }
    else {
        $errors['photo2'] = "Загрузите файл";
    }

    if(count($errors) > 0){
        $page_content = include_template('add_lot.php',['category' => $category ,
                                                    'lot_name' => $lot_name,
                                                    'category_id' => $category_id,
                                                    'message' => $message,
                                                    'lot_rate' => $lot_rate,
                                                    'lot_step' => $lot_step,
                                                    'lot_date' => $lot_date,
                                                    'file_url' => $file_url,
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

    $move_res = move_uploaded_file($_FILES['photo2']['tmp_name'], $file_path.$file_name);
    $sql = 'insert into lots (lot_name, description, image, start_price, step, category_id, date_close, author_id)
            values (?,?,?,?,?,?,?,?)';

    $stmt = db_get_prepare_stmt($connect, $sql, [
        strip_tags($lot['lot-name']), 
        strip_tags($lot['message']),
        strip_tags($file_url),
        intval($lot['lot-rate']), 
        intval($lot['lot-step']), 
        intval($lot['category']),
        date('Y-m-d', strtotime($lot['lot-date'])),
        intval($user_id)
    ]);
    $res = mysqli_stmt_execute($stmt);

    $new_id = mysqli_insert_id($connect);
    if($res){
        header("Location: /pages/lot.php?id=$new_id");
    }
    /*$page_content = include_template('succsess.php',['category' => $category]);*/
}
elseif(!isset($_SESSION['user'])) {
    header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden");
    $page_content = include_template('403.php',['category' => $category]);

}
else {
    $page_content = include_template('add_lot.php',['category' => $category ,
                                                    'lot_name' => $lot_name,
                                                    'category_id' => $category_id,
                                                    'message' => $message,
                                                    'lot_rate' => $lot_rate,
                                                    'lot_step' => $lot_step,
                                                    'lot_date' => $lot_date
                                                ]);
}

$data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => $category
    ];
$html = include_template('layout.php', $data);
echo $html;
