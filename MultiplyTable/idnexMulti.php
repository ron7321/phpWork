<?php

function multiply($number)
{
    echo "<table border='1' style='border-collapse: collapse'>"; // Создаем таблицу
    for ($i = 2; $i <= 9; $i++) { // Добавляем значения в таблицу
        echo "<tr>";
        echo "<td style='padding: 1rem'>" . numLink($number) . "*" . numLink($i) . "=" . $i * $number . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

if ($_GET["number"]) { // Проверка наличия GET
    if (filter_var($_GET["number"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) && $_GET["number"] > 1 && $_GET["number"] <= 9) { // Фильтрация параметра GET
        multiply($_GET["number"]); // Отрисовка отдельной таблицы
        echo "<br><a href='". $_SERVER["PHP_SELF"] ."'>COME BACK</a>"; // Кнопка возвращения домой
    } else {
        header("Location: " . $_SERVER["PHP_SELF"]); // Редирект на домашнюю страницу
        exit;
    }
} else {
    echo "<div style='display: flex;'>";
    for ($i = 2; $i <= 9; $i++) { // Отрисовка таблицы
        multiply($i);
    }
}

function numLink($number) { // Обертка цифр ссылками
    return "<a href='?number=$number'>$number</a>";
}

