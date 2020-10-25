// Отправка формы смены ответсвенного за выполнения  задачи на сервер
$(document).ready(function () {
    var elEditUserForm = document.getElementById('edit-task_modal_user-form'); // Форма смены ответсвенного

    addEvent(elEditUserForm, 'submit', function (e) {
        e.preventDefault();

        var elements = this.elements; // Элементы формы
        var task_id = elements.hidden_user.value; // Id редактируемой задачи
        var elSelectedUser = document.getElementById("task_modal_user-select").options.selectedIndex; // Выбранный пользователь
        var user_id = document.getElementById("task_modal_user-select").options[elSelectedUser].value; // Id пользователя

        // Переменные для ajax-запроса
        var action = "taskUpdate";

        // ajax-запрос отправки формы
        $.ajax({
            url: 'index.php',
            type: "POST",
            data: {
                ajax: action,
                id_task: task_id,
                update: 'user',
                initial_value: user_id
            },
            error: function () {
                alert('Что-то пошло не так!');
            },
            success: function (response) {

                // Получаем id отредактированной задачи и id пользователя
                var obj = jQuery.parseJSON(response);
                var task_id = obj['id_task'];
                var updated_user_name = obj['updated_value'][0];

                // Помещаем имя нового ответственного в карточку задачи и её превью
                var elUser = document.getElementById('task_modal_user');
                var idUserCardPreview = "username_task_" + task_id;
                var elUserCardPreview = document.getElementById(idUserCardPreview);
                elUser.textContent = updated_user_name;
                elUserCardPreview.textContent = updated_user_name;

                // Обновляем параметр для сортировки по имени ответсвенного
                var idColumnTask = document.getElementById("column_task_" + task_id); // Id превью задачи
                idColumnTask.setAttribute("data-sortUser", updated_user_name);

                elEditUserForm.setAttribute("hidden", "");// Скрываем форму изменения ответсвенного, елси нет доступа
                elUser.removeAttribute("hidden"); // Показываем едемент с именем ответсвенного, если он был скрыт
            },
            //dataType : "json"
        });
    })
})