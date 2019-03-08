<?php
define('BASE_DIR', realpath('..'));
require_once('../functions.php');
require_once('../connect.php');
session_start();

$user_name = $_SESSION['user']['user_name'] ?? '';
$user_id = $_SESSION['user']['id'] ?? '';
$search_word = '';

date_default_timezone_set('Europe/Kiev');

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
          'user_name' => $user_name,
          'category' => []
    ];
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    $html = include_template('layout.php', $data);
    echo $html;
    exit();
}

$category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);

if(isset($_GET['search']) && trim($_GET['search']) !== ''){
    $search_word = trim($_GET['search']);
    $search_word = mysqli_real_escape_string($connect, $search_word);
    $query_search = "select l.id, l.lot_name, l.image, l.start_price, l.category_id, c.categ_name, l.date_close, l.current_price, count(b.id) q_bets
                    from lots l
                    left join categories c on c.id = l.category_id
                    left join bets b on l.id = b.lot_id
                    where MATCH(lot_name,description) AGAINST('*$search_word*' in boolean mode)
                    group by l.id, l.lot_name, l.image, l.start_price, l.category_id, l.date_close, l.current_price
                    order by l.date_creation desc
                    limit 9";

    $res_search = mysqli_query($connect, $query_search);
    $search_num = mysqli_num_rows($res_search);

    if (!$res_search ) {
        $error = mysqli_error($connect);
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

    $search = mysqli_fetch_all($res_search, MYSQLI_ASSOC);
}
else{
    $error['search'] = "Ничего не найдено по вашему запросу";
    $page_content = include_template('search.php',['category' => $category,
                                                    'error' => $error]);
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

$page_content = include_template('search.php',['category' => $category,
                                            'search' => $search,
                                            'search_word' => $search_word
                                        ]);
$data = [
        'content' => $page_content,
        'title' => "Главная",
        'user_name' => $user_name,
        'category' => $category
    ];
$html = include_template('layout.php', $data);
echo $html;
    




