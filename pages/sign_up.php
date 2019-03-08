<?php
define('BASE_DIR', realpath('..'));
require_once('../functions.php');
require_once('../connect.php');

/*Variables for saving data from submited form*/
$email = $_POST['email'] ?? '';
$user_name = $_POST['name'] ?? '';
$message = $_POST['message'] ?? '';
$file_url = '/img/user.png';

$query_categories = "select categ_name from categories";

$res_categories = mysqli_query($connect, $query_categories);

$cat_num = mysqli_num_rows($res_categories);


if($email){
    $email = mysqli_real_escape_string($connect, $email);
	$query_email = "select email from users where email = '$email'";
	$res_email = mysqli_query($connect, $query_email);
	$email_num = mysqli_num_rows($res_email);
}

if (!$res_categories || $cat_num === 0) {
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

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $register = $_POST;
    $required_field = ['email', 'password', 'name', 'message'];
    $errors = [];
    $min_text = 5;
    $max_text = 30;
    $max_textarea = 255;

    // Do validation form, text of errors save in array $errors
    foreach($required_field as $field){
        if(empty($register[$field])){
            $errors[$field] = "Заполните поле";
        }
    }

    if(isset($register['email']) && !filter_var($register['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email имеет неправильный формат";
    }
    if(isset($register['email']) && mb_strlen($register['email']) > $max_text) {
    	$errors['email'] = "Длина email должна быть не больше $max_textarea символов";
    }
    if(isset($register['email']) && $email_num > 0) {
    	$errors['email'] = "Этот email уже занят";
    }
    if(isset($register['password']) && (mb_strlen($register['password']) < $min_text || mb_strlen($register['password']) > $max_text)){
        $errors['password'] = "Длина пароля должна быть от $min_text до $max_text символов";
    }
    if(isset($register['name']) && mb_strlen($register['name']) > $max_text){
        $errors['user_name'] = "Длина имени должна быть от $min_text до $max_text символов";
    }
    if(isset($register['message']) && mb_strlen($register['message']) >$max_textarea){
        $errors['message'] = "Максимальное количество символов $max_textarea";
    }

    if(isset($_FILES['photo2']) && ($_FILES['photo2']['size'])){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_name = $_FILES['photo2']['tmp_name'];
        $file_size = $_FILES['photo2']['size'];
        $file_type = finfo_file($finfo, $file_name);
        $file_path = BASE_DIR.'/img/uploaded_avatars/';
        $file_url = '/img/uploaded_avatars/';

        if($file_type !== 'image/png' && $file_type !== 'image/jpeg'){
	        $errors['photo2'] = "Загрузите картинку в одном из форматов: .png, .jpg, .jpeg";
	        $file_name = "";
	        $file_url = "";
	    }
	    elseif ($file_type === 'image/png') {
            $file_name = uniqid().'.png';
        }
        elseif ($file_type === 'image/jpeg') {
            $file_name = uniqid().'.jpeg';
        }

        if ($file_size > 2000000) {
            $errors['photo2'] = "Загрузите файл не больше 2Мб";
            $file_name = "";
            $file_url = "";
        }

        $file_url = $file_url.$file_name;

        $move_res = move_uploaded_file($_FILES['photo2']['tmp_name'], $file_path.$file_name);
    } 
    
    if(count($errors) > 0){
        $page_content = include_template('sign_up.php',['category' => $category ,
        											'email' => $email,
        											'user_name' => $user_name,
                                                    'message' => $message,
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

    $sql = 'insert into users (user_name, email, pass, avatar, contact)
            values (?,?,?,?,?)';

    $stmt = db_get_prepare_stmt($connect, $sql, [
        strip_tags($register['name']), 
        strip_tags($register['email']),
        password_hash($register['password'], PASSWORD_DEFAULT),
        strip_tags($file_url),
        strip_tags($register['message'])
    ]);
    $res = mysqli_stmt_execute($stmt);

    $new_id = mysqli_insert_id($connect);
    if($res){
        header("Location: /pages/login.php");
    }
    /*$page_content = include_template('succsess.php',['category' => $category]);*/
}

$page_content = include_template('sign_up.php', ['category' => $category,
												'email' => $email,
    											'user_name' => $user_name,
                                                'message' => $message,
                                            	'file_url' => $file_url]);

$data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => $category
    ];
    $html = include_template('layout.php', $data);
    echo $html;