<?php
include_once('../controllers/C_Page.php'); // Контроллер страниц
include_once('../controllers/C_Ajax.php'); // Контроллер для ajax-запросов
include_once('../models/m_ajax.php'); // Модель для ajax-запросов
session_start(); // Начинаем сессию

// Проверяем включен ли JS в браузере у пользователя
$_SESSION['JS_ON'] = (!empty($_SESSION['JS_ON']) || !empty($_GET['js'])); // JS_ON == true, если он установлен в сессии или пришёл get-параметр "js=1"
if (!$_SESSION['JS_ON'] && empty($_SESSION['JS_CHECKED']) && $_SESSION['JS_OFF'] != 1) {
    echo '<script type="text/javascript">top.location.href="?js=1";</script>'; // записываем get-параметр в адресную строку через JS
    $_SESSION['JS_OFF'] = 1; // Проверяем это условие только при первом псещении страницы
}
if (!isset($_SESSION['JS_CHECKED'])) { // Если JS_CHECKED не установлен, то устанавливаем его спомощью get-параметра записанного через JS
    $_SESSION['JS_CHECKED'] = $_GET['js'];
}

// Получаем action с обозначением страницы из URL
$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index'; // Если URL пустой, загружаем главную страницу

// Определяем, поступил ли ajax-запрос
$isAjax = getAjax();

// Если нет, загружаем новую страницу
if (!$isAjax) {
    $controller = new C_page(); // Объявляем объект новой страницы
    $controller->$action(); // Определяем, какя это будет страница
    $controller->render(); // Генерируем шаблон страницы
}
// Если да, получаем данные через ajax-запрос
else {
    $controller = new C_Ajax(); // Объкт с полученными данными
    $controller->$isAjax();
}


