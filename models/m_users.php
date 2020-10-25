<?php
require_once('db.php');
/**
 * Модель таблицы users
 */

// Получаем данные пользователя по его Id
function getUser($id_user)
{
    $id_user = (int)$id_user;

    try {
        $q = "SELECT * FROM users WHERE user_id = ".$id_user;
        $sql = SQL::getInstance()->Select($q);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $sql;
}

// Получаем имя пользователя по его Id
function getUserName($id_user)
{
    $id_user = (int)$id_user;

    try {
        $q = "SELECT user_name FROM users WHERE user_id = ".$id_user;
        $sql = SQL::getInstance()->Select($q);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $sql[0];
}

// Получаем данные таблицы Users
function getUsersData(){
    try {
        $q = "SELECT * FROM users";
        $sql = SQL::getInstance()->Select($q);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    return $sql;
};

// Добавляем нового пользователя
function setUser(){
    try {
        $password = $_POST['password'];
        $user_name = $_POST['name'];
        $user_login = $_POST['login'];
        $user_email = $_POST['email'];
        $user_password = hashPassword($password);
        $t = 'users';
        $v = array('user_name' => $user_name, 'login' => $user_login, 'password'
        => $user_password, 'email' => $user_email);

        $sql = SQL::getInstance()->Insert($t, $v);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
}
