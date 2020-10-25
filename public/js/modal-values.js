// Выводим данные задачи в модальном окне
$(document).ready(function () {
    function getTaskValues(e) {
        // Если не отключен JS, отправляем ajax-запрос
        if (!e.preventDefault()) {
            var url = "index.php";
            var action = "taskItem"; // Метод редактирования данных задачи
        }

        // Элементы для переменных задачи
        var elTitle = document.getElementById('task_modal_title'); // Имя задачи
        var elDescription = document.getElementById("task_modal_description"); // Описание задачи
        var elUser = document.getElementById("task_modal_user"); // Ответственный
        var elTaskUserHiddenId = document.getElementById("hidden-user-id"); // Input hidden содержащий id ответсвенного
        var elTaskCreatedDate = document.getElementById('modal-task-created-date'); // Дата создания задачи
        var elTaskDeadLine = document.getElementById('task_modal_deadline'); // Срок исполненеия

        var elTaskCompleteButton = document.getElementById("edit-task_modal_status-button"); // Кнопка "Выполнена/Не выполнена"
        var elTaskStatus = document.getElementById('task_modal_status'); // Статус задачи
        var elTaskId = document.getElementById("task_modal_id"); // Скрытый элемент, содержащий id задачи

        // Кнопки "Изменить" и "Удалить" могут видеть только админ или ответственный
        var elEditButtons = document.getElementsByClassName("edit-button");
        var editButtonAmount = elEditButtons.length;
        for (var i = 0; i < editButtonAmount; i++) {
            elEditButtons[i].setAttribute("hidden", "");
        }

        // Скрываем формы редактирования если были открыты
        var elEditForms = document.getElementsByClassName("edit-form");
        var editFormAmount = elEditForms.length;
        for (var i = 0; i < editFormAmount; i++) {
            elEditForms[i].setAttribute("hidden", "");
        }

        // Показываем элементы с данными задачи, если были скрыты
        var elInitialValues = document.getElementsByClassName("initial-value");
        var initialValuesAmount = elInitialValues.length;
        for (var i = 0; i < initialValuesAmount; i++) {
            elInitialValues[i].removeAttribute("hidden");
        }

        // Получаем id задачи из атрибута id
        var target_id = e.target.id;
        var obj_id = target_id.split('_');
        var task_id = obj_id[2];

        elTaskId.textContent = task_id; // Помещаем id задачи в скрытый элемент

        // Помещаем id задачи в поля форм input hidden для редактирования данных задачи
        var elHiddenInputId = document.getElementsByClassName("hidden-task-id"); // Поля input hidden в которые поместим id задачи
        var hiddenInputAmount = elHiddenInputId.length; // Количество элементов с полем input hidden
        for (var i = 0; i < hiddenInputAmount; i++) {
            elHiddenInputId[i].setAttribute('value', task_id);
        }

        $.ajax({
            url: url,
            type: "GET",
            data: {
                ajax: action,
                id_task: task_id
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (data) {
                var obj = jQuery.parseJSON(data)[0]; // Объект с данными задачи
                var userLogin = obj['login']; // Логин зашедшего пользователя

                // Показываем кнопки "Удалить" и "Изменить" для админа или ответсвенного
                if (typeof(sessionUserLogin) != "undefined" && sessionUserLogin != null) {
                    if (sessionUserLogin == userLogin || sessionUserLogin == 'admin') {
                        for (var i = 0; i < editButtonAmount; i++) {
                            elEditButtons[i].removeAttribute("hidden");
                        }
                    }
                }

                var created_date = obj['created_at']; // Получаем дату создания задачи в Unix timestamp
                var dead_line = obj['dead_line']; // Получаем дату создания задачи в Unix timestamp

                // Отображаем данные задачи в модальном окне
                elTitle.textContent = obj['task_name']; // Имя задачи
                elDescription.textContent = obj['description']; // Описание задачи
                elUser.textContent = obj['user_name']; // Ответственный
                elTaskCreatedDate.textContent = timestampToDate(created_date); // Дата создания задачи
                elTaskDeadLine.textContent = timestampToDate(dead_line).substr(0, 16); // Срок выполнения задачи без секунд
                elTaskStatus.textContent = obj['status_name']; // Статаус задачи

                // Помещаем id исходного ответственного в поле input hidden для отображения его в <select> при смене пользователя, ответсвенного за выполнение задачи
                elTaskUserHiddenId.setAttribute('value', obj['user_id']);

                // Изменяем кнопку смены статауса, если статус задачи "выполнена"
                if (elTaskStatus.textContent == "выполнена") {
                    elTaskCompleteButton.textContent = "Не выполнена";
                    elTaskCompleteButton.classList.replace('btn-success', 'btn-warning');
                }
            },
        });
    }

// Превью карточек задач
    var taskRow = document.getElementById("row-tasks");

// При клике на превью, вызываем фукцию подставляющую переменные в модальное окно с карточкой задачи
    taskRow.addEventListener('click', function (e) {
        getTaskValues(e);
    }, true);

})
