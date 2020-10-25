<script>
    <?
    // Определяем пользователя для вывода полей задачи, к которым у него есть права
    if (isset($_SESSION['user']['login'])){;?>
    var sessionUserLogin = "<? echo $_SESSION['user']['login']; ?>";
    <?}
    ?>
</script>

<!-- Модальное окно задачи -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <!-- id задачи -->
                <p id="task_modal_id" hidden></p>

                <!-- Название задачи -->
                <h1 class="modal-title initial-value card-title" id="task_modal_title"></h1>

                <!-- Форма редактирования названия -->
                <form class="edit-form" id="edit-task_modal_title-form" hidden>
                    <div class="group" id="group-for-title-input">
                        <label for="task_modal_title-input">Название задачи </label>
                        <span id="input-for-title"><input type="text" id="task_modal_title-input" name="task_name" placeholder="Название задачи"></span>
                    </div>

                    <input id="hidden-title" class="hidden-task-id" name="hidden_title" type="hidden">

                    <div class="group" align="center">
                        <button id="edit-title-post" class="btn btn-outline-light">Отправить</button>
                    </div>
                </form>

                <!-- Кнопка "Редактировать" -->
                <button class="btn btn-outline-light edit-button edit-text-button" id="edit-task_modal_title-button" hidden>Изменить</button>

                <!-- Кнопка закрытия модального окна -->
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <!-- Описание задачи -->
                <h5 class="task-body-label">Описание задачи: </h5>
                <button class="btn btn-outline-light edit-button edit-text-button edit-body-button" id="edit-task_modal_description-button" hidden>Изменить</button>

                <p id="task_modal_description" class="task_description initial-value"></p>

                <!-- Форма редактирования описания -->
                <form class="edit-form" id="edit-task_modal_description-form" hidden>
                    <div class="group" id="group-for-description-textarea">
                        <div id="textarea-for-description">
                            <textarea type="text" id="task_modal_description-textarea" name="task_description"></textarea>
                        </div>
                    </div>

                    <input id="hidden-description" class="hidden-task-id" name="hidden_description" type="hidden">

                    <div class="group" align="center">
                        <button id="edit-description-post" class="btn btn-outline-light">Отправить</button>
                    </div>
                </form>

                <!-- Ответственный -->
                <p class="task-body-label">Ответственный: <span class="initial-value" id="task_modal_user"></span></p>

                <!-- Форма изменения ответственного -->
                <form class="edit-form" id="edit-task_modal_user-form" hidden>
                    <div class="group">
                        <label for="task_modal_user-select">Выберете ответственного</label>
                        <select id="task_modal_user-select" name="task-user-select"></select>
                    </div>

                    <input id="hidden-user" class="hidden-task-id" name="hidden_user" type="hidden">
                    <input id="hidden-user-id" name="hidden_user_id" type="hidden">

                    <div class="group" align="center">
                        <button id="edit-user-post" class="btn btn-outline-light">Отправить</button>
                    </div>
                </form>

                <button class="btn btn-outline-light edit-button edit-body-button" id="edit-task_modal_user-button" hidden>Изменить</button>
                </br>

                <!-- Срок выполнения задачи -->
                <p class="task-body-label">срок выполнения:
                    <em class="initial-value" id="task_modal_deadline"></em>
                </p>

                <!-- Форма изменения срока выполнения -->
                <form class="edit-form" id="edit-task_modal_deadline-form" hidden>

                    <div class="group">
                        <label for="date">Дата: </label>
                        <input type="date" id="task_modal_date-input" name="task_date"/>
                    </div>

                    <div class="group">
                        <label for="time">Время: </label>
                        <input type="time" id="task_modal_time-input" name="task_time"/>
                    </div>

                    <input id="hidden-date" class="hidden-task-id" name="hidden_deadline" type="hidden">

                    <div class="group" align="center">
                        <button id="edit-date-post" class="btn btn-outline-light">Отправить</button>
                    </div>
                </form>

                <button class="btn btn-outline-light edit-button edit-body-button" id="edit-task_modal_deadline-button" hidden>Изменить</button>

                <!-- Статус задачи -->
                <p>Статус: <em class="initial-value" id="task_modal_status"></em></p>

                <!-- Дата создания задачи -->
                <p>создана:
                    <em id="modal-task-created-date"></em>
                </p>

            </div>

            <div class="modal-footer">
                <!-- Кнопка изменения статуса -->
                <button class="btn btn-success edit-button" id="edit-task_modal_status-button">Выполнена</button>
                <!-- Кнопка удаления -->
                <button class="btn btn-danger edit-button" id="edit-task_modal_delete-button">Удалить</button>
            </div>
        </div>
    </div>
</div>

