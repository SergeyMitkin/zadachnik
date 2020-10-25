<?php
require_once('db.php');

/**
 * Модель авторизации
 */
/**
 * валидация пользовательского куки
 * @return bool
 */

// Регистрируем пользователяя через куки
function checkAuthWithCookie(){
    $result = false;

    if(isset($_COOKIE['user_id']) && isset($_COOKIE['cookie_hash'])) {
        // получаем данные пользователя по id
        try {
            $q = "SELECT user_id, login, user_name, password FROM users WHERE user_id = '" . $_COOKIE['user_id'] . "'"; // Подготовленное выражение
            $sql = SQL::getInstance()->Select($q); // Обращаемся к БД
            $row = $sql['0'];

            // Полученные из БД данные пользователя
            $id = $row['user_id']; // Id
            $hash_password = $row['password']; // Зашифрованный пароль

            // Если не соответствуют id пользователя и пароль в куки, просрочиваем куки
            if (($hash_password !== $_COOKIE['user_hash']) || ($id !== $_COOKIE['user_id'])) {
                setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
            } else {
                // Если авторизовали через куки, переходим на главную страницу
                header("Location: /");
            }

            $_SESSION['user'] = $row; // Создаём сессию для пользователя
            $result = true;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
        return $result;
}

// Залогиниваем по логину и паролю
function authWithCredentials(){
    // Получаем данные из формы авторизации
    $user_login = $_POST['login'];
    $password = $_POST['password'];

    try{
        // Получаем данные пользователя по логину из БД
        $q = "SELECT user_id,  login, user_name, password FROM users WHERE login = '$user_login'";
        $sql = SQL::getInstance()->Select($q);
        $row = $sql['0'];

        // Данные пользователя, полученные из БД
        $id = $row['user_id'];
        $login = $row['login'];
        $hash_password = $row['password'];
        $isAuth = 0;

        // Проверяем соответствие логина и пароля
        if ($login && $hash_password) {
            if(checkPassword($password, $hash_password)){
                $isAuth = 1;
            }
        }

        // Если стояла галка "Запомнить меня", то запоминаем пользователя на сутки
        if(isset($_POST['remember_me']) && $_POST['remember_ыme'] == 'on'){
            setcookie("user_id", $id, time()+86400);
            setcookie("cookie_hash", $hash_password, time()+86400);
        }

        // сохраняем данные в сессию
        $_SESSION['user'] = $row;
    }

    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $isAuth;
}

// Проверяем логин на уникальность
function checkExistedLogin(){
    $login = $_POST['login'];
    try {
        $q = "SELECT user_id, login FROM users WHERE login = '$login'";
        $sql = SQL::getInstance()->Select($q);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return (!empty($sql));
}

// Шифруем введённый пароль
function hashPassword($password)
{
    $salt = md5(uniqid(SALT2, true));
    $salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);
    return crypt($password, '$2a$08$' . $salt);
}

// Проверяем пароль
function checkPassword($password, $hash){
    return crypt($password, $hash) === $hash;
}

// Проверяем залогинен ли уже пользователь
function alreadyLoggedIn(){
    return isset($_SESSION['user']);
}