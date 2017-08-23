<?php

function render($path, array $params = array())
{
    ob_start();                     //  Перехватываем поток вывода
    extract($params);               //  Применяем только полученные в функцию параметры
    include($path);
    $output = ob_get_contents();    //  Берем собержимое буфера вывода

    ob_end_clean();

    return $output;
}

/*
*  Метод для конвертации номера месяца в словесное представление в родительном падеже
*/
function convertMonth(DateTime $date)
{
    $months = array(
        'января', 'февраля', 'марта',
        'апреля', 'мая', 'июня',
        'июля', 'августа', 'сентября',
        'октября', 'ноября', 'декабря');
    $month = $months[(int)$date->format('n') - 1];
    return $month;
}

function getURI()
{
    if (!empty($_SERVER['REQUEST_URI'])) {
        return trim($_SERVER['REQUEST_URI'], '/');
    }
}