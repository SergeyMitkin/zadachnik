<?php
/**
 * Основной шаблон
 * =======================
 * $text - текст
 */
?>

<!-- Шаблон создания/редактирования задачи -->
<div class="create-container">
    <!-- Выводим ответ о создании/редактировании задачи -->
    <?=$response?>

    <!-- Форма создания/редактирования задачи -->
    <form method="post" action ='?act=create'/>
        <h1><?=$create_or_update?></h1>

            <!-- Если есть $_GET['edit'], редактируем задачу -->
            <?
            if($_GET['edit'] == 'on'){
                ?>

                <div class="group">
                    <input type="hidden" id="task_id" name="task_id" value="<?=$task_id?>">
                </div>

                <div class="group">
                    <p>Ответственный: <?=$user_name?></p>
                    <input type="hidden" id="user_id" name="user_id" value="<?=$user_id?>">
                </div>

                <div class="group">
                    <label for="task_name">Название задачи </label>
                    <input type="text" id="task_name" name="task_name" value="<?=$task_name?>" placeholder="Название задачи">
                </div>

                <div class="group">
                    <label for="description">Описание задачи </label>
                    <textarea name="description" value="<?=$task_description?>" placeholder="Описание задачи"><?=$task_description?></textarea>
                </div>

                <div class="group">
                    <p>Срок выполнения: <?=$dead_line?></p>
                    <input type="hidden" id="dead_line" name="dead_line" value="<?=$dead_line?>">
                </div>

            <?}

            // Иначе, создаём новую задачу задачу
            else{?>
                <div class="group">
                    <label for="user">Выберете ответственного</label>
                    <select id="user" name="user">
                    <?php
                    foreach($usersData as $user) {
                    echo '<option value="' . $user['user_id'] . '">' . $user['user_name'] . '</option>';
                    }
                    ?>
                    </select>
                </div>

                <div class="group">
                    <label for="task_name">Введите название задачи </label>
                    <input type="text" id="task_name" name="task_name" value="<?=$task_name?>" placeholder="Название задачи">
                </div>

                <div class="group">
                    <label for="description">Введите описание задачи </label>
                    <textarea id="description" name="description" value="<?=$task_description?>" placeholder="Описание задачи"></textarea>
                </div>

                <div class="group">
                    <label for="date">Срок выполнения: </label>
                    <input type="date" id="date" name="date" value="<?=$date?>"/>
                </div>

                <div class="group">
                    <label for="time">Время: </label>
                    <input type="time" id="time" name="time" value="<?=$time?>"/>
                </div>
            <?}?>

            <div class="group" align="center">
                <button type="submit" class="btn btn-light">Отправить</button>
            </div>
    </form>
</div>