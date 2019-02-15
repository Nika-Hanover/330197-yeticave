<?php
function price_format($number){
    $number = ceil($number);
    $number = number_format($number, 0, ',', ' ');
    return $number.' '.'&#8381;';
};
$is_auth = rand(0, 1);

date_default_timezone_set('Europe/Kiev');
$current_date = strtotime('now');
$next_midnight = strtotime('tomorrow');
$interval_hours = date('H:i', ($next_midnight - $current_date));

$connect = mysqli_connect('localhost', 'root', '', 'yeticave');

if($connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    $query_lots = "select l.lot_name name, c.categ_name category_name, l.start_price price, l.image img, l.step 
            from lots l
            join categories c on l.category_id = c.id
            where date_format(date_close,'%Y-%m-%d') > date_format(SYSDATE(),'%Y-%m-%d')
            order by date_creation desc";
    $query_categories = "select categ_name name from categories";

    $res_lots = mysqli_query($connect, $query_lots);
    $res_categories = mysqli_query($connect, $query_categories);

    if (!$res_lots || !$res_categories) {
        $error = mysqli_error($connect);
        print("Ошибка MySQL: ".$error);
    } 

    $category = mysqli_fetch_all($res_categories, MYSQLI_ASSOC);
    $lots_list = mysqli_fetch_all($res_lots, MYSQLI_ASSOC);
}

$user_name = 'Nika'; // укажите здесь ваше имя

require_once('functions.php');
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