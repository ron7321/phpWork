<?php
if (!empty($_GET)) {
    header('Location: ' . $_SERVER['PHP_SELF']); // Редирект на форму при лишнем GET
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) { // Обработка POST запроса и проверка на наличие данных
    $name = trim(strip_tags($_POST['name']));
    $login = trim(strip_tags($_POST['login']));
    $age = trim(strip_tags($_POST['age']));
    $password = trim(strip_tags($_POST['password']));

    if ($name && $login && $age && $password) { // Запихиваем данные  в куки
        for ($i = 1; $i <= 10; $i++) { // Шифровка пароля
            $password = sha1($password);
        }
        setcookie('name', $name, time() + 30000);
        setcookie('login', $login, time() + 30000);
        setcookie('age', $age, time() + 30000);
        setcookie('password', $password, time() + 30000);

        if (!$_COOKIE['count']) { // Если куков нет, условие их создаст, если есть будет прибавлять количество заходов
            setcookie('count', 1, time() + 30000);
        } else {
            setcookie('count', $_COOKIE['count'] + 1, time() + 30000);
        }
    }
    if ($_POST['EXIT']) { // Удаление куков
        setcookie('name', $name, time() - 30000);
        setcookie('login', $login, time() - 30000);
        setcookie('age', $age, time() - 30000);
        setcookie('password', $password, time() - 30000);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Редирект на форму
    exit();
}

if ($_COOKIE['password'] && $_COOKIE['login'] && $_COOKIE['name'] && $_COOKIE['age']) { // Отрисовка страницы после регистрации
    echo 'Logged<br>';
    echo "Вы зашли на сайт {$_COOKIE['count']} раз";
    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
            <input type="submit" name="EXIT" value="EXIT">
        </form>';
} else { // Форма регистрации
    echo "<div style='display: flex; width: 10%; flex-wrap: wrap;'><form action='indexReg.php' method='post'> 
        <input type='text' name='name' placeholder='Name' required>
        <input type='email' name='login' placeholder='Login' required>
        <input type='number' name='age' min='15' max='100' placeholder='Age' required>
        <input type='password' name='password' placeholder='Password' required>
        <input type='submit' value='Log in'>
      </form></div>";
}






//session_start();
//
//if ($_SERVER["REQUEST_METHOD"] == "GET") {
//    $salt = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
//    $_SESSION["secretKey"] = $salt;
//    echo "<form method='post'>
//            <input type='number' max='10' name='myNumber'>
//            <input type='submit' value='Send'>
//            <input type='hidden' value='$salt' name='secretKey'>
//         </form>";
//} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
//    if ($_POST["secretKey"] == $_SESSION["secretKey"]) {
//        echo "<a> Твое число: " . $_POST["myNumber"] . "</a>";
//    } else {
//        echo "NE TOT KEY";
//        echo "<br><a href='". $_SERVER["PHP_SELF"] ."'>COME BACK AND TRU AGAIN</a>";
//    }
//}