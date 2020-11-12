// Пагинация
'use strict';

var numberOfItems = $("#row-tasks .list-group").length; // Число страниц
var limitPerPage = 6; // Количество превью задач на странице
$("#row-tasks .list-group:gt(" + (limitPerPage - 1) + ")").hide(); // Скрываем задачи не на первой странице
var totalPages = 0; // Переменная для общего количества страниц

// Удаляем ссылку для пагинации без JS на кнопке для "предыдущая страница"
var elPreviousA = document.getElementById("previous-page");
elPreviousA.setAttribute("href", "javascript:void(0)");

// Удаляем li с номерами страниц для пагинации с JS
var elPageNumbers = document.getElementById("li_page_numbers");
elPageNumbers.remove();

// Удаляем li с кнопкой "следующая задача" для пагинации с JS
var elNextPage = document.getElementById("li_next_page");
elNextPage.remove();

// Определяем количество страниц
if (numberOfItems % limitPerPage == 0){
    totalPages = numberOfItems / limitPerPage;
} else if (numberOfItems % limitPerPage != 0){
    totalPages = Math.floor(numberOfItems / limitPerPage) + 1;
}

// Добавляем кнопку с номером первой страницы
$(".pagination").append("<li class='current-page active page-item first-page'>" +
    "<a class='page-link btn' href='javascript:void(0)'>" + 1 + "</a>" +
    "</li>");

// Добавлем кнопки с номерами остальных страниц
for (var i = 2; i <= totalPages; i++){
    $(".pagination").append("<li class='current-page page-item'>" +
        "<a class='page-link btn' href='javascript:void(0)'>" + i + "</a>" +
        "</li>");
}

// Добавляем кнопку "Следующая страница"
$(".pagination").append("<li id='next-page' class='page-item'><a class='page-link' href='javascript:void(0)' aria-label='Next'><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>");

// При нажатии на кнопку с номером страницы, переодим на эту страницу
$(".pagination li.current-page").on("click", function () {
    // Если нажимаем на активную страницу, возвращаем false
    if ($(this).hasClass("active")){
        return false;

        // Иначе, переходим на эту страницу
    } else {
        var currentPage = $(this).index(); // Определяем страницу

        $(".pagination li").removeClass("active"); // Делаем все страницы неактивными
        $(this).addClass("active"); // Делаем страницу, на которую перешли активной
        $('#row-tasks .list-group').hide(); // Скрываем превью задач
        var grandTotal = limitPerPage * currentPage; // Определяем последнюю задачу, которая должна появиться на странице

        // Выводим задачи на этой странице
        for (var i = grandTotal - limitPerPage; i < grandTotal; i++){
            $("#row-tasks .list-group:eq(" + i + ")").show();
        }
    }
})

// При нажатии на кнопку "Следующая страница", переходим на следующую страницу
$("#next-page").on("click", function () {
    var currentPage = $(".pagination li.active").index(); // Определяем активную страницу
    // Если это последняя страница, возвращаем false
    if (currentPage === totalPages){
        return false;
        // Иначе, переходим на следующую
    } else {
        currentPage++; // Инкрементируем номер текущей страницы
        $(".pagination li").removeClass("active"); // Делаем все страницы неактивными
        $('#row-tasks .list-group').hide(); // Скрываем превью всех задач

        var grandTotal = limitPerPage * currentPage; // Определяем последнюю задачу, которая должна появиться на странице

        // Выводим задачи на этой странице
        for (var i = grandTotal - limitPerPage; i < grandTotal; i++){
            $("#row-tasks .list-group:eq(" + i + ")").show();
        }

        // Делаем страницу, на которую перешли активной
        $(".pagination li.current-page:eq(" + (currentPage - 1) + ")").addClass("active");
    }
})

// При нажатии на кнопку "Предыдущая страница", переходим на предыдущую страницу
$("#previous-page").on("click", function () {
    var currentPage = $(".pagination li.active").index(); // Определяем активную страницу

    // Если это первая страница, возвращаем false
    if (currentPage === 1){
        return false;
    } else {
        // Декрементируем номер текущей страницы
        currentPage--;
        $(".pagination li").removeClass("active"); // Делаем все страницы неактивными
        $('#row-tasks .list-group').hide(); // Скрываем все страницы

        var grandTotal = limitPerPage * currentPage; // Определяем последнюю задачу, которая должна появиться на странице

        // Выводимзадачи на этой странице
        for (var i = grandTotal - limitPerPage; i < grandTotal; i++){
            $("#row-tasks .list-group:eq(" + i + ")").show();
        }

        // Делаем страницу, на котору перешли активной
        $(".pagination li.current-page:eq(" + (currentPage - 1) + ")").addClass("active");
    }
})

