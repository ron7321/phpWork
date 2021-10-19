<?php

session_start(); // Начало сессии

if ($_SERVER["REQUEST_METHOD"] == "GET") { // Обработка GET запроса
    $salt = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)); // Создание рандомной строки
    $_SESSION["secretKey"] = $salt;
    echo "<form method='post'> //Отрисовка формочки
            <input type='number' max='10' name='myNumber'>
            <input type='submit' value='Send'>
            <input type='hidden' value='$salt' name='secretKey'>
         </form>";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") { // Обработка POST запроса
    if ($_POST["secretKey"] == $_SESSION["secretKey"]) { //Сравнение значений
        echo "<a> Твое число: " . $_POST["myNumber"] . "</a>"; // Если все хорошо, отрисовка отправленного числа
    } else {
        echo "NE TOT KEY";
        echo "<br><a href='". $_SERVER["PHP_SELF"] ."'>COME BACK AND TRY AGAIN</a>";
    }
}

