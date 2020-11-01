<?php

/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 28.04.2020
 * Time: 18:27
 */
include_once('../models/m_tasks.php'); // Модель для работы с таблицей tasks
include_once('../models/m_users.php'); // Модель для работы с таблицей users
include_once('Controller.php'); // Класс шаблонизатора

// Класс для работы с ajax-запросами
class C_Ajax extends Controller // Наследуем от класса шаблонизатора
{
    // Генерация внешнего шаблона
    public function render()
    {

    }

    // Получаем редактируемую задачу по id
    public function taskItem()
    {
        $id_task = $_GET['id_task'];
        $task_data = getTask($id_task);
        echo $task_data;
    }

    // Получаем дянные пользователей
    public function getUsers(){
        $users = getUsersData();
        echo json_encode($users);
    }

    // Радактируем данные задачи
    public function taskUpdate(){
        $response = []; // Массив с новыми данными
        $task_id = $_POST['id_task']; // Id задачи
        $update = $_POST['update']; // Новое значение
        $initial_value = $_POST['initial_value']; // Исходное значение

        switch ($update) {
            // Редактируем название задачи
            case "title":
                $updated_value = updateTaskName($task_id, $initial_value);
                break;

            // Редактируем описание задачи
            case "description":
                $updated_value = updateTaskDescription($task_id, $initial_value);
                break;

            // Редактируем ответственного
            case "user":
                $updated_user_id = updateTaskUser($task_id, $initial_value); // Устанавливаем нового ответсвенного, получаем его id
                $updated_value = getUserName($updated_user_id); // Получаем имя нового ответсвенного по его id
                break;

            // Редактируем срок выполнения
            case "deadline":
                $updated_value = updateTaskDeadline($task_id, $initial_value);
                break;

            // Редактируем статус задачи
            case "status":
                $updated_value = completedTask($task_id, $initial_value); // ОБновляем статус, определяем его id
                break;

            // Удаляем задачу
            case "delete":
                $updated_value = deleteTask($task_id);
        }

        $response['id_task'] = $task_id; // Id редактируемой задачи
        $response['updated_value'] = $updated_value; // Обновлённые данные
        $response_json = json_encode($response); // Кодируем в json

        echo $response_json;
    }
}