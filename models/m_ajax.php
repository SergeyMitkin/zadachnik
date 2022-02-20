<?php
// Получаем ajax-запрос из get или post параметра
function getAjax(){
    $isAjax = '';

    if (isset($_GET['ajax'])){
        $isAjax = $_GET['ajax'];
    }elseif (isset($_POST['ajax'])){
        $isAjax = $_POST['ajax'];
    }else{
        $isAjax = false;
    }

    return $isAjax;
};