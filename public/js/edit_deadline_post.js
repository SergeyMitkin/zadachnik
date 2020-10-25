// Отправка формы редактирования срока выполнения задачи на сервер

$(document).ready(function () {
    var elEditDeadlineForm = document.getElementById('edit-task_modal_deadline-form'); // Форма редактирования срока выполнения задачи

    addEvent(elEditDeadlineForm, 'submit', function (e) {
        e.preventDefault();
        var elements = this.elements; // Элементы формы
        var initial_date = elements.task_date.value; // Отправленная дата
        var initial_time = elements.task_time.value; // Отправленное время
            var initial_value = +new Date(initial_date + " " + initial_time) / 1000; // Переводим дату и время в Unix

        var task_id = elements.hidden_deadline.value; // Id задачи

        var action = "taskUpdate";

        $.ajax({
            url: 'index.php',
            type: "POST",
            data: {
                ajax: action,
                id_task: task_id,
                update: 'deadline',
                initial_value: initial_value
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (response) {

                // Получаем имя и id отредактированной задачи
                var obj = jQuery.parseJSON(response); // Данные задачи
                var task_id = obj['id_task']; // Id задачи

                var updated_task_deadline = timestampToDate(obj['updated_value']).substr(0, 16); // Новое значения срока исполнения без секунд

                var elDeadline = document.getElementById('task_modal_deadline'); // Элемент, отображающий срок выполнения
                var idDeadlineCardPreview = "deadline-span_task_" + task_id; // Id элемента, отображающего deadline на превью задачи
                var elDeadlineCardPreview = document.getElementById(idDeadlineCardPreview); // Элемент, отображающий deadline на превью задачи

                // Отображение обновлённого срока выполнения на превью и в карточке задачи
                elDeadline.textContent = updated_task_deadline;
                elDeadlineCardPreview.textContent = updated_task_deadline;

                // Обновляем параметр сортировки в превью
                var idColumnTask = document.getElementById("column_task_" + task_id);
                idColumnTask.setAttribute("data-sort-deadline", obj['updated_value']);

                elEditDeadlineForm.setAttribute("hidden", ""); // Скрываем форму редактирования срока выполнения
                elDeadline.removeAttribute("hidden"); // Показываем элемент со сроком выполнения

            },
            //dataType : "json"
        });
    })
})