// Отправка формы редактирования названия задачи на сервер

$(document).ready(function () {
    var elEditTitleForm = document.getElementById('edit-task_modal_title-form'); // Форма редактирования имени задачи

    addEvent(elEditTitleForm, 'submit', function (e) {
        e.preventDefault();
        var elements = this.elements; // Элементы формы
        var initial_value = elements.task_name.value; // Отправляем отредактированное имя задачи на сервер
        var task_id = elements.hidden_title.value; // Получаем Id задачи из скрытого поля формы

        var action = "taskUpdate"; // Действие для ajax-запроса

        $.ajax({
            url: 'index.php',
            type: "POST",
            data: {
                ajax: action,
                id_task: task_id,
                update: 'title',
                initial_value: initial_value,
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (response) {

                // Получаем имя и id отредактированной задачи
                var obj = jQuery.parseJSON(response); // Данные задачи, пришедшие с сервера
                var task_id = obj['id_task']; // Id задачи
                var updated_task_name = obj['updated_value']; // Отредактированное имя
                var elTitle = document.getElementById('task_modal_title'); // Элемент, отображающийимя задачи
                var idTitleCardPreview = "title_task_" + task_id; // HTML атрибут id превью задачи
                var elTitleCardPreview = document.getElementById(idTitleCardPreview); // Элемент с превью задачи на главной странице

                elTitle.textContent = updated_task_name; // Помещаем отредактированное имя в соответсвующий элемент в модальном окне
                elTitleCardPreview.textContent = updated_task_name; // Помещаем отредактированное имя в соответсвующий элемент в превью задачи

                elEditTitleForm.setAttribute("hidden", ""); // Скрываем форму изменения названия
                elTitle.removeAttribute("hidden"); // Показываем элемент с названием задачи

            },
            //dataType : "json"
        });
    })
})
