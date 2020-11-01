<?php
require_once('db.php');
/**
 * Модель таблицы ststus
 * @return array
 */
// Получаем данные таблицы status
function getStatusData(){
    try {
        $q = "SELECT * FROM `status`";
        $sql = SQL::getInstance()->Select($q);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    return $sql;
}