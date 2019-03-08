<?php
define('BASE_DIR', realpath('..'));
require_once('../functions.php');
require_once('../connect.php');
session_start();

$user_name = $_SESSION['user']['user_name'] ?? '';

/*Variables for saving data from submited form*/
$email = isset($_POST['email']) ?? '';

$query_categories = "select categ_name from categories";

$res_categories = mysqli_query($connect, $query_categories);

$cat_num = mysqli_num_rows($res_categories);

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
        'user_name' => '',
        'category' => []
    ];
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

$category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $login = $_POST;
    $required_field = ['email', 'password'];
    $errors = [];
    // Do autentification user, text of errors save in array $errors
    foreach($required_field as $field){
        if(empty($login[$field])){
            $errors[$field] = "Заполните поле";
        }
    }

    if($login['email']){
    	$email = mysqli_real_escape_string($connect, $login['email']);
		$query_email = "select email from users where email = '$email'";
		$res_email = mysqli_query($connect, $query_email);
		$email_num = mysqli_num_rows($res_email);
	}

	if($email_num !== 0){
		$email = mysqli_real_escape_string($connect, $login['email']);
		$query_user = "select id, user_name, email, pass, avatar, contact from users where email = '$email'";
		$res_user = mysqli_query($connect, $query_user);
		$user = mysqli_fetch_assoc($res_user);

		if(password_verify($login['password'], $user['pass'])){
			$_SESSION['user'] = $user;
		}
		else {
			$errors['password'] = "Неверный пароль";
		}
	}
	else {
			$errors['email'] = "Данный email не зарегистрирован ни за одним из пользователей";
	}
		
    if(count($errors) > 0){
        $page_content = include_template('login.php',['category' => $category ,
        											'email' => $email,
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

    header("Location: /");
    
    /*$page_content = include_template('succsess.php',['category' => $category]);*/
}
$page_content = include_template('login.php', ['category' => $category,
												'email' => $email,
    											'user_name' => $user_name]);

$data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => $category
    ];
    $html = include_template('layout.php', $data);
    echo $html;