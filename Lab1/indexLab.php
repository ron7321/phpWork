<?php
$arr = [ // Массив данных, содержащий пункты горизонтального и вертикального меню
    'Главная' => [
        'page' => 'Главная',
        'html' => 'page1.html'
    ],
    'Родители' => [
        'page' => 'Родители',
        'html' => 'page2.html',
        'children' => [
            'children1' => [
                'parent' => 'Родители',
                'page' => 'children1',
                'html' => 'children1.html'
            ],
            'children2' => [
                'parent' => 'Родители',
                'page' => 'children2',
                'html' => 'children2.html'
            ],
            'children3' => [
                'parent' => 'Родители',
                'page' => 'children3',
                'html' => 'children3.html'
            ],
        ]
    ],
    'page3' => [
        'page' => 'Registration',
        'html' => 'Register.html'
    ],
];

function menu($arr, $gor = true, $parent = null) // Функция вывода горизонтального/вертикального меню
{
    if ($gor) { // Вывод горизонтального меню
        $html = '<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">';

        foreach ($arr as $item) {
            $html .= '<li class="nav-item">
            <a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $item['page'] . '">' . $item['page'] . '</a>
          </li>';
        }
        $html .= "</ul>
        </div>
      </nav>";
    } elseif (!$gor) { // Вывод вертикального меню
        $html = '<nav class="sidebar-sticky bg-light navbar-light navbar-expand-lg" style="padding: 0rem 1rem">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav flex-column">';
        foreach ($arr as $item) {
            $html .= '<li class="nav-item">
            <a class="nav-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $parent . '&children=' . $item['page'] . '">' . $item['page'] . '</a>
          </li>';
        }
        $html .= "</ul>
        </div>
      </nav>";
    }

    return $html;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') { // Обработка GET запроса
    if ($_GET['page']) { // Проверка наличия параметра
        foreach ($arr as $item) {
            if ($_GET['page'] == $item['page']) { // Проверка корректности параметра
                $page = $item;
            }
        }
        if ($page) {
            if ($_GET['children'] && $page['children']) { // Проверка наличия параметра children
                foreach ($page['children'] as $item) {
                    if ($_GET['children'] == $item['page']) { // Проверка корректности параметра
                        $children = $item;
                    }
                }
                if (!$children) {
                    header('Location: ' . $_SERVER['PHP_SELF']); // Редирект при некоректном параметре children
                    exit();
                }
            }
            echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">';
            echo menu($arr); // Вывод горизонтального меню
            if ($page['children']) { // Проверка на наличие дочерних страниц
                echo menu($page['children'], false, $_GET['page']); // Вывод вертикального меню
            }
            if ($children) {
                require_once($children['html']); // Добавление содержимого страницы
                exit();
            }
        } else {
            header('Location: ' . $_SERVER['PHP_SELF']); // Редирект при некоректном параметре page
            exit();
        }
    } else {
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">';
        echo menu($arr); // Вывод вертикального меню
    }
}
