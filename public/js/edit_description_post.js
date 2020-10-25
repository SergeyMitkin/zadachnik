// Отправка формы редактирования описания задачи на сервер

$(document).ready(function () {
    var elEditDescriptionForm = document.getElementById('edit-task_modal_description-form'); // Форма редактирования описания задачи

    addEvent(elEditDescriptionForm, 'submit', function (e) {
        e.preventDefault();
        var elements = this.elements; // Элементы формы
        var initial_value = elements.task_description.value; // Отправляем отредактированное описание задачи
        var task_id = elements.hidden_description.value; // Получаем Id задачи из скрытого поля формы

        var action = "taskUpdate"; // Действие для ajax-запроса

        $.ajax({
            url: 'index.php',
            type: "POST",
            data: {
                ajax: action,
                id_task: task_id,
                update: 'description',
                initial_value: initial_value
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (response) {

                // Получаем имя и id отредактированной задачи
                var obj = jQuery.parseJSON(response); // Данные задачи, пришедшие с сервера
                var task_id = obj['id_task']; // Id задачи
                var updated_task_description = obj['updated_value']; // Отредактированное описание

                var elDescription = document.getElementById('task_modal_description'); // Элемент с описанием задачи
                var idDescriptionCardPreview = "description_task_" + task_id; // HTML атрибут id превью задачи
                var elDescriptionCardPreview = document.getElementById(idDescriptionCardPreview); // Элемент с превью задачи на главной странице

                elDescription.textContent = updated_task_description; // Помещаем отредактированное описание в соответсвующий элемент в модальном окне
                elDescriptionCardPreview.textContent = updated_task_description; // Помещаем отредактированное описание в соответсвующий элемент в превью задачи

                elEditDescriptionForm.setAttribute("hidden", ""); // Скрываем форму редактирования описания
                elDescription.removeAttribute("hidden"); // Показываем элемент с описанием задачи

            },
            //dataType : "json"
        });
    })
})