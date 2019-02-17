<?php
function include_template($name, $data = null) {
    $name = BASE_DIR.'/templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();
    return $result;
}

/*Представляем значение цены с разделителями тысяч и добавляем знак рубля*/
function price_format($number){
    $number = round($number);
    $number = number_format($number, 0, ',', ' ');
    return $number.' '.'&#8381;';
};

/*Функция показывает разницу во времени. Если разница меньше 24 часов от текущего времени, то показывает сколько прошло минут или часов, иначе представляет дату в формате 'd.m.y'.' в '.'H:i'*/
function diff_result($date){
    $diff = time()-strtotime($date);
    $answer = '';
    if ($diff >= 86400) {
        $answer = date('d.m.y', strtotime($date)).' в '.date('H:i', strtotime($date));
    }
    elseif ($diff >= 16200) {
        $answer = round($diff/3600).' часов назад';
    }
    elseif ($diff >= 5400) {
        $answer = round($diff/3600).' часа назад';
    }
    elseif ($diff >= 3600) {
        $answer = 'час назад';
    }
    elseif ($diff >= 270) {
        $answer = round($diff/60).' минут назад';
    }
    elseif ($diff >= 90) {
        $answer = round($diff/60).' минуты назад';
    }
    elseif ($diff >= 60) {
        $answer = 'минуту назад';
    }
    else{
        $answer = 'только что';
    }
    return $answer;
}; 