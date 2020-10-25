<?php
require_once('db.php');
/**
 * Модель таблицы tasks
 */

// Подключаем PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-6.1.7/src/Exception.php';
require '../PHPMailer-6.1.7/src/PHPMailer.php';
require '../PHPMailer-6.1.7/src/SMTP.php';

// Получаем массив задач с условиями пагинации и сортировки
function getTasks($results_per_page, $order, $order_value){
    // Первая задача на странице
    $first_result = 0;
    if (isset($_GET['first_result'])){
        $first_result = $_GET['first_result'];
    }

    // Задаём параметр сортировки
    $sort_sql = 'tasks.created_at'; // Изначально сортируем по дате создания задачи

        if ($order_value == 'user_name') {
            $sort_sql = 'user_name'; // По имени ответсвенного
        } else if ($order_value == 'dead_line') {
            $sort_sql = 'dead_line'; // По сроку выполнения
        } else if ($order_value == 'status') {
            $sort_sql = 'status_name'; // По статусу
        }

        // Получаем данные задач на странице из БД
    try {
            // Подготовленное выражение
        $q = "SELECT tasks.task_id, tasks.task_name, tasks.created_at, tasks.dead_line,
            user_name, email, description, id_status, status_name  
            FROM tasks
            LEFT JOIN users ON tasks.id_user = users.user_id
			LEFT JOIN `status` ON tasks.id_status = `status`.status_id  
            ORDER BY " . $sort_sql . " " . $order . " LIMIT " . $first_result . "," . $results_per_page;
        $sql = SQL::getInstance()->Select($q); // Обращение к БД
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
        return $sql;
}

// Получаем данные конкретной задачи по id
function getTask($id_task)
{
    $id_task = (int)$id_task;

    try {
        $q = "SELECT * FROM tasks
        LEFT JOIN users ON tasks.id_user = users.user_id 
        LEFT JOIN `status` ON tasks.id_status = `status`.status_id
        WHERE task_id = ".$id_task;
        $sql = SQL::getInstance()->Select($q);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    if ($_GET['ajax']) {
        return json_encode($sql);
    } else {
        return $sql;
    }
}

function sendEmail($admin_email, $user_name, $user_login, $task_name, $dead_line){

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.mail.ru';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'li-mukhammed@mail.ru';                     // SMTP username
        $mail->Password   = '7qfnj8Mz9ATSyNB';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet = "utf-8";

        //Recipients
        $mail->setFrom('li-mukhammed@mail.ru');
        $mail->addAddress($admin_email);                     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);

        $mail->Subject = 'Создана задача';
        $mail->Body    = 'Для пользователя ' . $user_name . '(логин ' . $user_login .
            ') создана задача <br>' . $task_name . '<br> Срок исполнения: ' . $dead_line;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

// Определяем Id последней добавленной задачи
function getLastInsertedTaskId(){

    try {
        $q = "SELECT task_id FROM tasks ORDER BY task_id DESC limit 1";
        $sql = SQL::getInstance()->Select($q);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $sql[0][0];
}

// Получаем количество задач для пагинации
function getTasksCount(){
        try {
            $q = "SELECT COUNT(*) FROM tasks";
            $sql = SQL::getInstance()->Select($q);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
        return $sql['0']['0'];
}

// Добавляем или редактируем задачу
function setTask($id_task = 0,$task_name, $task_description, $id_user, $dead_line, $id_status = 2){

    $response = '';
    $id_task = (int)$id_task;
    $date_now = time(); // Текущее время в Unix timestamp
    $dead_line_unix = strtotime((string)$dead_line); // Преобразовываем введённый срок выполнения в Unix timestamp

    // Переменные для подготовленного выражения
    try {
        $description = $task_description;
        $t = 'tasks';
        $v = array(
            'task_name' => $task_name,
            'description' => $description,
            'id_user' => $id_user,
            'id_status' => $id_status,
            'created_at' => $date_now,
            'dead_line' => $dead_line_unix
        );

        // Если Id задачи больше 0, значит задача редактируется
        if($id_task > 0) {

            $w = "task_id =" . $id_task; // Id редактируемой задачи

            // Обращаемся к БД
            $sql = SQL::getInstance()->Update($t, $v, $w);
            $response = 'Задача отредактирована';
        }

        // Иначе добавляем новую задачу
        else{
            $sql = SQL::getInstance()->Insert($t, $v);
            $response = 'Задача добавлена';
        }
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $response;
}

// Редактируем название задачи
function updateTaskName($id_task,$task_name){
    $response = '';
    $id_task = (int)$id_task;
    try {
        $t = 'tasks';
        $v = array(
            'task_name' => $task_name,
        );
        $w = "task_id =" . $id_task;

        $sql = SQL::getInstance()->Update($t, $v, $w);
        $response = $task_name;
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $response;
}

// Редактируем описание задачи
function updateTaskDescription($id_task, $task_description){
    $response = '';
    $id_task = (int)$id_task;
    try {
        $t = 'tasks';
        $v = array(
            'description' => $task_description,
        );
        $w = "task_id =" . $id_task;

        $sql = SQL::getInstance()->Update($t, $v, $w);
        $response = $task_description;
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $response;
}

// Редактируем срок выполнения задачи
function updateTaskDeadline($id_task, $task_deadline){
    $response = '';
    $id_task = (int)$id_task;
    try {
        $t = 'tasks';
        $v = array(
            'dead_line' => $task_deadline,
        );
        $w = "task_id =" . $id_task;

        $sql = SQL::getInstance()->Update($t, $v, $w);
        $response = $task_deadline;
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $response;
}

// Изменяем ответсвенного за выполнения задачи
function updateTaskUser($id_task, $id_user){
    $response = '';
    $id_task = (int)$id_task;
    try {
        $t = 'tasks';
        $v = array(
            'id_user' => $id_user,
        );
        $w = "task_id =" . $id_task;

        $sql = SQL::getInstance()->Update($t, $v, $w);
        $response = $id_user;
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $response;
}

// Удаляем задачу
function deleteTask($task_id){
    $response = '';
    $task_id = (int)$task_id;

    try{
        $table = 'tasks';
        $where = "task_id = " . $task_id;
        $sql = SQL::getInstance()->Delete($table, $where);
        $response = 'Задача удалена';
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $response;
}

// Обновляем статус задачи
function completedTask($task_id, $id_status){
    $task_id = (int)$task_id;
    $id_status = (int)$id_status;

    try {
        $t = 'tasks';
        $v = array('id_status' => $id_status);
        $w = "task_id =" . $task_id;
        $sql = SQL::getInstance()->Update($t, $v, $w);
        $response = $id_status;
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
    return $id_status;
}

// Получаем статус задачи
function getTaskStatus($task_status_id){
    try {
        $q = "SELECT id_status FROM tasks
        WHERE task_id = ".$task_status_id;
        $sql = SQL::getInstance()->Select($q);
    }
    catch(PDOException $e){
        die("Error: ".$e->getMessage());
    }
        return $sql;
}