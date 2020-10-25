$(document).ready(function () {

// Условие для перехода на главную страницу
if (window.parent.location.href.match(/res/)){
    if (typeof (history.pushState) != "undefined"){
        var obj = { Title: document.title, Url: window.parent.location.pathname};
        history.pushState(obj, obj.Title, obj.Url);
    } else {
        window.parent.location = window.parent.location.pathname;
    }
}
})

// Записываем текущий год в строку со сведениями од авторский правах
// Создаем переменную для хранения нового объекта Date (по умолчанию)
var today = new Date();
// Создаем переменную для хранения текущего года
var year = today.getFullYear();

// Создаем переменную el для записи элемента с идентификатором footer
var el = document.getElementById('copyright');
// Записываем значение года в элемент.
el.innerHTML = 'Все права защищены &copy;' + year;