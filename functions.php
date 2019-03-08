<?php
/**
* Подключает шаблон страницы и проводит буферизацию содержимого подключаемого файла
* @param $name string имя файла
* @param $data array массив переменных, которые используются в шаблоне
*
* @return Возвращает содержимое буфера вывода и заканчивает буферизацию вывода
*/
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

/**
* Представляем значение цены с разделителями тысяч и добавляем знак рубля
* @param $number int число
*
* @return string отформатированное число
*/
function price_format($number){
    $number = round($number);
    $number = number_format($number, 0, ',', ' ');
    return $number.' '.'&#8381;';
};

/**
* Функция показывает разницу во времени. Если разница меньше 24 часов от текущего времени, то показывает сколько прошло минут или часов, иначе представляет дату в формате 'd.m.y'.' в '.'H:i'
* @param $data string дата, которую мы хотим представить в нужном формате
* @param $diff int внутренняя переменная функции, содержит разницу во времени (количество секунд) между текущим временем и временем, переданным в переменной $date
*
* @return $answer переменная содержит нужный нам формат времени
*/
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
* Функция показывает разницу во времени до завершения публикации лота. Если разница больше 1 дня добавляется количество дней иначе выводится только количесво часов и минут.
* @param $data string дата в будущем, до которой мы хотим посчитать сколько отсалось времени на данный момент
* @param $diff int внутренняя переменная функции, содержит разницу во времени (количество секунд) между временем, переданным в переменной $date и текущим временем
*
* @return $answer переменная содержит временной промежуток в нужном формате
*/
function interval_date($date){
    $diff = strtotime($date) - time();
    $day = floor($diff/86400);
    $hours = floor(($diff - $day*86400)/3600);
    $minutes = floor(($diff - $day*86400 - $hours*3600)/60);
    $d = $day%10;
    $h = $hours%10;
    $m = $minutes%10;
    $answer = '';

    if($hours < 10){
        $hours = '0'.$hours;
    }
    if($minutes < 10){
        $minutes = '0'.$minutes;
    }

    if($diff <= 0){
        $answer = '00:00';
    }
    elseif ($diff > 86400 && in_array($d, [5,6,7,8,9,0])) {
        $answer =  $day.' дней';
    }
    elseif ($diff > 86400 && in_array($d, [2,3,4])) {
        $answer = $day.' дня ';
    }
    elseif ($diff > 86400 && $d === 1) {
        $answer = $day.' день ';
    }
    elseif ($diff = 86400 && $d === 1) {
        $answer = $day.' день '.$hours.':'.$minutes;
    }
    else {
        $answer = $hours.':'.$minutes;
    }
    return $answer;
}; 

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param $data array Данные для вставки на место плейсхолдеров
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
