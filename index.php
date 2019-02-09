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

$user_name = 'Nika'; // укажите здесь ваше имя
$category = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$lots_list = [
            ['name' => '2014 Rossignol District Snowboard',
            'category_name' => 'Доски и лыжи',
            'price' => '10999',
            'img' => 'img/lot-1.jpg'
            ],
            ['name' => 'DC Ply Mens 2016/2017 Snowboard',
            'category_name' => 'Доски и лыжи',
            'price' => '159999',
            'img' => 'img/lot-2.jpg'
            ],
            ['name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'category_name' => 'Крепления',
            'price' => '8000',
            'img' => 'img/lot-3.jpg'
            ],
            ['name' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'category_name' => 'Ботинки',
            'price' => '10999',
            'img' => 'img/lot-4.jpg'
            ],
            ['name' => 'Куртка для сноуборда DC Mutiny Charocal',
            'category_name' => 'Одежда',
            'price' => '7500',
            'img' => 'img/lot-5.jpg'
            ],
            ['name' => 'Маска Oakley Canopy',
            'category_name' => 'Разное',
            'price' => '5400',
            'img' => 'img/lot-6.jpg'
            ]
];
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