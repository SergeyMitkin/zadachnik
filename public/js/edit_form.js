// Формы редактирования данных задачи в моадьном окне и удаление задачи

// При нажатии кнопки "Изменить" при редактировании имени задачи
$(document).ready(function () {
    $("#edit-task_modal_title-button").on('click', function () {

        var elTitle = document.getElementById("task_modal_title"); // Элемент с именем задачи

        var elTitleForm = document.getElementById("edit-task_modal_title-form"); // Форма редактирования имени задачи
        var elChangeButton = document.getElementById("edit-task_modal_title-button"); // Кнопка "Изменить"

        var elSpanForInput = document.getElementById("input-for-title"); // Input для редактирования имени задачи
        var groupForInput = document.getElementById("group-for-title-input"); // Родительский элемент для input
        var initialTitle = elTitle.textContent;     // Исходное имя задачи

        groupForInput.removeChild(elSpanForInput); // Удаляем старый input, так как возможно там сохранились данные от редактирования предыдущей задачи

        // Создаём новый input и передаём туда редактируемое имя задачи
        var sp = document.createElement("span");
        sp.innerHTML = '<input type="text" id="task_modal_title-input" name="task_name" value="' + initialTitle + '">';
        sp.id = "input-for-title";

        groupForInput.appendChild(sp); // Добавляем новый input в форму

        elTitle.setAttribute("hidden", ""); // Скрываем элемент со значением поля
        elTitleForm.removeAttribute("hidden"); // Показываем форму редактирования
        elChangeButton.setAttribute("hidden", ""); // Скрываем кнопку "Изменить"

    })
})
// При нажатии кнопки "Изменить" при редактировании описания задачи
$(document).ready(function () {
    $("#edit-task_modal_description-button").on('click', function () {

        var elDescription = document.getElementById("task_modal_description"); // Элемент с описанием задачи
        var elDescriptionForm = document.getElementById("edit-task_modal_description-form"); // Форма редактирования описания
        var elChangeButton = document.getElementById("edit-task_modal_description-button"); // Кнопка "Изменить"

        var elDivForTextarea = document.getElementById("textarea-for-description"); // Textarea для  редактирования имени задачи
        var groupForTextarea = document.getElementById("group-for-description-textarea"); // Родительский элемент для textarea
        var initialDescription = elDescription.textContent;     // Исходное описание задачи

        groupForTextarea.removeChild(elDivForTextarea); // Удаляем старую textarea, так как возможно там сохранились данные от редактирования предыдущей задачи

        // Создаём новую textarea и передаём туда редактируемое описание задачи
        var dv = document.createElement("div");
        dv.innerHTML = '<textarea type="text" id="task_modal_description-textarea" name="task_description">' + initialDescription + '</textarea>';
        dv.id = "textarea-for-description";

        groupForTextarea.appendChild(dv); // Добавляем новую textarea в форму

        elDescription.setAttribute("hidden", ""); // Скрываем элемент со значением поля
        elDescriptionForm.removeAttribute("hidden"); // Показываем форму редактирования
        elChangeButton.setAttribute("hidden", ""); // Скрываем кнопку "Изменить"
    })
})

// При нажатии кнопки "Изменть" при изменении срока выполнения задачи
$(document).ready(function () {
    $("#edit-task_modal_deadline-button").on('click', function () {

        var elDeadline = document.getElementById("task_modal_deadline"); // Элемент, выводящий срок выполнения задачи
        var elDeadlineForm = document.getElementById("edit-task_modal_deadline-form"); // Форма изменения срока выполнения
        var elChangeButton = document.getElementById("edit-task_modal_deadline-button"); // Кнопка "Изменить"

        var elInputForChangeDate = document.getElementById("task_modal_date-input"); // Input для ввода даты (дня) выполнения
        var elInputForChangeTime = document.getElementById("task_modal_time-input"); // Input для ввода времни выполнения

        var initialDeadline = elDeadline.textContent; // Исходный срок выполнения
        var initialDate = initialDeadline.split(" ")[0]; // Исходная дата (день)
        var initialTime = initialDeadline.split(" ")[1].substr(0, 5); // Исходное время без секунд

        elInputForChangeDate.setAttribute("value", initialDate); // Помещаем исходную дату (день) в input для изменения
        elInputForChangeTime.setAttribute("value", initialTime); // Помещаем исходное время в input для изменения

        elDeadline.setAttribute("hidden", ""); // Скрываем элемент со значением поля
        elDeadlineForm.removeAttribute("hidden"); // Показываем форму редактирования
        elChangeButton.setAttribute("hidden", ""); // Скрываем кнопку "Изменить"
    })
})

// При нажатии кнопки "Изменить" при смене ответсвенного за выполнение задачи
$(document).ready(function () {
    $('#edit-task_modal_user-button').on('click', function () {

        var elUser = document.getElementById('task_modal_user'); // Элемент, выводящий имя ответсвенного
        var elUserId = document.getElementById('hidden-user-id') // Input hidden, содержащий id ответственного
        var userId = elUserId.getAttribute('value'); // Получаем Id ответсвенного

        var elEditUser = document.getElementById('edit-task_modal_user-form'); // Форма для редактирования
        var elEditUserButton = document.getElementById("edit-task_modal_user-button"); // Кнопка "Изменить"

        // ajax-запрос для получения списка пользователей
        var url = "index.php";
        var action = "getUsers";
        $.ajax({
            url: url,
            type: "GET",
            data: {
                ajax: action,
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (data) {
                var obj = jQuery.parseJSON(data); // Получаем данные таблицы users
                var users_number = obj.length; // Количество пользователей

                var elUsersSelect = document.getElementById('task_modal_user-select') // Select для выбора пользователя
                var options = '<option value = "' + userId + ' " >' + elUser.textContent + '</option>'; // Помещаем исходного ответственного в первый <option>

                // Помещаем в <option> остальных пользователей
                for (var i = 0; i < users_number; i++) {
                    options += '<option value="' + obj[i]['user_id'] + '">' + obj[i]['user_name'] + '</option>';
                }
                elUsersSelect.innerHTML = options;
            },
        });

        elUser.setAttribute("hidden", ""); // Скрываем элемент с именем ответсвенного
        elEditUser.removeAttribute("hidden"); // Показываем форму редактирования
        elEditUserButton.setAttribute("hidden", ""); // Скрываем кнопку "Изменить"
    });
})

// При нажатии кнопки "Выполнена" или "Не выполнена" меняем статус задачи
$(document).ready(function () {
    $("#edit-task_modal_status-button").on('click', function () {

        var elStatus = document.getElementById("task_modal_status"); // Элемент, выводящий статус задачи
        var elCompleteButton = document.getElementById("edit-task_modal_status-button"); // Кнопка "Выполнена/Не выполнена"
        var task_id = document.getElementById("task_modal_id").textContent; // Id задачи

        // Меняем статус задачи с "выполнена" на "не выполнена" и наоборот
        if (elStatus.textContent == "выполнена") {
            var updated_status_id = 2; // Новый id статуса задачи
        } else {
            var updated_status_id = 1;
        }

        var action = "taskUpdate";

        $.ajax({
            url: 'index.php',
            type: "POST",
            data: {
                ajax: action,
                id_task: task_id,
                update: 'status',
                initial_value: updated_status_id
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (response) {
                // Получаем id задачи и id статуса
                var obj = jQuery.parseJSON(response);

                var task_id = obj['id_task'];
                var status_id = obj['updated_value'];

                // Получаем элемент превью
                var idStatusCardPreview = "status_task_" + task_id;
                var elStatusCardPreview = document.getElementById(idStatusCardPreview);

                var idColumnTask = document.getElementById("column_task_" + task_id); // Получаем id превью задачи

                // Устанавливаем обозначения для обновлённого статуса
                // Если задача "Не выполнена"
                if (status_id == 1) {
                    elStatus.textContent = "выполнена" // Статус в карточке задачи
                    elCompleteButton.textContent = "Не выполнена"; // На кнопке о выполнении
                    elCompleteButton.classList.replace('btn-success', 'btn-warning'); // Стиль для кнопки о выполнении
                    elStatusCardPreview.setAttribute('src', 'img/completed.png'); // Значок о выполнении в превью задачи
                    idColumnTask.setAttribute("data-sortStatus", "выпонена"); // Обновляем параметр для сортировки
                } else {
                    elStatus.textContent = "не выполнена"; // Статус в карточке задачи
                    elCompleteButton.textContent = "Выполнена"; // На кнопке о выполнении
                    elCompleteButton.classList.replace('btn-warning', 'btn-success'); // Стиль для кнопки о выполнении
                    elStatusCardPreview.setAttribute('src', 'img/uncompleted.png'); // Значок о выполнении в превью задачи
                    idColumnTask.setAttribute("data-sortStatus", "не выполнена"); // Обновляем параметр для сортировки
                }
            },
            //dataType : "json"
        });
    })
})

// При нажатии кнопки "Удалить", удаляем задачу
$(document).ready(function () {
    $("#edit-task_modal_delete-button").on('click', function () {

        var task_id = document.getElementById("task_modal_id").textContent; // Id задачи

        // ajax-запрос
        var action = "taskUpdate";

        $.ajax({
            url: 'index.php',
            type: "POST",
            data: {
                ajax: action,
                id_task: task_id,
                update: 'delete',
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (response) {
                var obj = jQuery.parseJSON(response);
                var res = obj['updated_value'];

                // Если задача удалена, перезагружаем страницу
                if (res == "Задача удалена") {
                    window.location.reload();
                } else {
                    alert('Что-то пошло не так!!!');
                }
            },
            //dataType : "json"
        });
    })
})

