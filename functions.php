<?php
require_once('connect.php');

function include_template($name, $data = null) {
    $file_template_name = BASE_DIR.'/templates/' . $name;
    $result = '';

    if (!is_readable($file_template_name)) {
        return $result;
    }
   
    ob_start();
    extract($data);
    require $file_template_name;

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


/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($connect, $sql, $data = []) {
    $stmt = mysqli_stmt_init($connect);
    // var_dump($stmt);
    if (!mysqli_stmt_prepare($stmt, $sql)) return false;
    if (is_array($data)) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;
            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }
            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);
        mysqli_stmt_bind_param(...$values);
    }
    return $stmt;
}

function show_error(&$content, $error) {
    $content = include_template('error.php', ['error' => $error]);
};
