<?php
//
// Конттроллер загружаемых страниц.
//

// Импортируем модели и базовый контроллер
include_once('../models/m_tasks.php'); // Модель таблицы задач
include_once('../models/m_auth.php'); // Модель авторизации
include_once('../models/m_users.php'); // Модель таблицы пользователей
include_once('../models/m_status.php'); // Модель таблицы status
include_once('../models/m_validation.php'); // Модель валидации форм
include_once('C_Base.php'); // Базовый контроллер

// Наследуем контроллер страниц от базового контроллера
class C_Page extends C_Base
{
	// Конструктор
	function __construct(){		
		parent::__construct();
	}

	// главная страница
	public function action_index(){

        // определяем переменные для шаблона
        $this->title .= 'Главная'; // Заголовок
        $greetings = 'Здравствуйте!'; // Приветсвие
        $order_value = ''; // Переменная для подстановки параметра сортировки

        // Выводим на кнопки значения сортировки
        $nav_title_sort_user_name = 'По имени пользователя (a-z↓)';
        $nav_title_sort_date = 'По сроку выполнения (→)';
        $nav_title_sort_status = 'Выполненные';
//        $nav_title_sort_status = 'По статусу (a-z↓)';

        $statusData = getStatusData();// Данные таблицы status
        $usersData = getUsersData();  // Данные таблицы users

        // Возможные параметры сортировки:
        $sort_user_name = 'user_name'; // По имени пользователя
        $sort_date = 'dead_line'; // По сроку выполнения
        $sort_status = 'status'; // По статусу

        // Если есть $_GET['sort'] выполняем сортировку
        if (isset($_GET['sort'])) {

            switch ($_GET['sort']){

                // Сортировка по имени пользователя:
                case 'user_name':
                    $sort_user_name = '-user_name'; // При следующем нажатии на кнопку изменяем порядок сортировки
                    $order_value = 'user_name'; // Передаём в sql-запрос парарметр для сортировки
                    $order = 'ASC';             // Указываем порядок сортировки
                    $nav_title_sort_user_name = 'По имени пользователя (z-a↓)'; // Отображаем порядок сортировки на кнопке
                    break;
                case '-user_name';
                    $sort_user_name = 'user_name'; // При следующем нажатии на кнопку изменяем порядок сортировки
                    $order_value = 'user_name'; // Передаём в sql-запрос парарметр для сортировки
                    $order = 'DESC'; // Указываем порядок сортировки
                    $nav_title_sort_user_name = 'По имени пользователя (a-z↓)';// Отображаем порядок сортировки на кнопке
                    break;

                // Сортировка по сроку выполнения:
                case 'dead_line':
                    $sort_date = '-dead_line'; // При следующем нажатии на кнопку изменяем порядок сортировки
                    $order_value = 'dead_line'; // Передаём в sql-запрос парарметр для сортировки
                    $order = 'ASC';             // Указываем порядок сортировки
                    $nav_title_sort_date = 'По сроку выполнения (←)'; // Отображаем порядок сортировки на кнопке
                    break;
                case '-dead_line';
                    $sort_date = 'dead_line'; // При следующем нажатии на кнопку изменяем порядок сортировки
                    $order_value = 'dead_line'; // Передаём в sql-запрос парарметр для сортировки
                    $order = 'DESC'; // Указываем порядок сортировки
                    $nav_title_sort_date = 'По сроку выполнения (→)';// Отображаем порядок сортировки на кнопке
                    break;

                // Сортировка по статусу:
                case 'status':
                    $sort_status = '-status'; // При следующем нажатии на кнопку изменяем порядок сортировки
                    $order_value = 'status'; // Передаём в sql-запрос парарметр для сортировки
                    $order = 'ASC';             // Указываем порядок сортировки
                    $nav_title_sort_status = 'Текущие'; // Отображаем порядок сортировки на кнопке
                    break;
                case '-status';
                    $sort_status = 'status'; // При следующем нажатии на кнопку изменяем порядок сортировки
                    $order_value = 'status'; // Передаём в sql-запрос парарметр для сортировки
                    $order = 'DESC'; // Указываем порядок сортировки
                    $nav_title_sort_status = 'Текущие';// Отображаем порядок сортировки на кнопке
                    break;
            }
        }

        // Пагинация:
        $tasksCount = getTasksCount(); // Получаем количесвто задач
        $results_per_page = 0; // Объявляем переменную для количества задач на странице

        // Если JS не отключён, выводим на страницу все задачи, для работы с ними через JS
        $results_per_page = ($_SESSION['JS_CHECKED'] == '1') ? $tasksCount : 6; // Если JS отключен, задаём количество задач на странице

        // Определяем количество страниц с задачами
        $count_pages = (intdiv($tasksCount, $results_per_page)); // Число для количества страниц без остатка от деления
        $count_pages_total = ($tasksCount % $results_per_page ? $count_pages + 1 : $count_pages); // Если есть остатотк от деления, добавляем одну страницу

        $tasks = getTasks($results_per_page, $order, $order_value); // Массив с задачами
        // Получаем текущую страницу
        $page = (!isset($_GET['page'])) ? 1 : $_GET['page'];

        // Приветствие
        if(isset($_SESSION['user'])) {
            $greetings = "Привет, " . $_SESSION['user']['user_name']."!";
        }

        // Подключаем шаблон модального окна
        $modal = $this->Template('../views/v_modal.php', array(
        ));

        // Помещаем переменные в шаблон главной страницы
		$this->content = $this->Template('../views/v_index.php', array(
		    'greetings' => $greetings, // Приветствие
            'nav_title_sort_user_name' => $nav_title_sort_user_name, // Отображение значения сортировки по имени пользователя
            'nav_title_sort_status' => $nav_title_sort_status, // Отображение значения сортировки по статусу
            'nav_title_sort_date' => $nav_title_sort_date, // Отображение значения сортировки по сроку выполнения
            'sort_user_name' => $sort_user_name, // Значение сортировки по имени пользователя в get-параметре
            'sort_date' => $sort_date, // Значение сортировки по сроку выполнения в get-параметре
            'sort_status' => $sort_status, // Значение сортировки по статусу задачи в get-параметре
            'results_per_page' => $results_per_page, // Количество задач на странице в get-параметре
		    'tasksCount' => $tasksCount, // Количество задач
		    'count_pages' => $count_pages_total, // Количество страниц
            'statusData' => $statusData, // Данные значения статуса
            'usersData' => $usersData, // Данные пользователя
		    'tasks' => $tasks, // Массив с задачами
            'order' => $order, // Порядок сортировки
            'page' => $page, // Текущая страница
            'active' => ' ', // Активня ссылка
            'modal' => $modal, // Шаблон модального окна
            ));
	}

	// Страница для создания или редактирования задачи на php
    public function action_create(){
            $create_or_update = 'Создайте задачу'; // Заголовок страницы
            $usersData = getUsersData(); // Получаем данные таблицы Users
            $task_name = ''; // Объявляем имя задачи
            $task_description = ''; // Описание задачи

            // Объявляем константы для отправки сообщений
            // логин бота t.me/zadachnik1984_bot
            define('SMTP_EMAIL', 'li-mukhammed@mail.ru');
            define('ADMIN_EMAIL', 'sergeymitkin@gmail.com'); // email админа
            define('TELEGRAM_TOKEN', '1409865615:AAGHCkrCf3fMv2KQIvrykgFjJEGLdcaAWWw'); // Токен телеграм-бота
            define('TELEGRAM_CHATID', '460227562'); // Телеграм-id админа

            // Если есть id_task в get-параметре, значит задача редактируется
            if (isset($_GET['id_task'])){
                $create_or_update = 'Редактирование задачи'; // Заголовок страницы

                // Получаем информацию о задаче по её id
                $task_data = getTask($_GET['id_task'])['0']; // Данные редактируемой задачи
                $task_id = $task_data['task_id']; // Id задачи
                $task_name = $task_data['task_name']; // Имя задачи
                $task_description = $task_data['description']; // Описание задачи
                $user_name = $task_data['user_name']; // Имя ответсвенного
                $user_id = $task_data['user_id']; // Id ответсвенного
                $status_name = $task_data['status_name']; // Статус задачи
                $created_at = $task_data['created_at']; // Когда создана задача
                $dead_line = $task_data['dead_line']; // Срок выполнения
            }

            $this->title .= $create_or_update; // Заголовок страницы

        // Отправляем данные созданной или отредактированной задачи
        if($this->isPost()){
            $task_id = $_POST['task_id']; // Id задачи
            $task_name = $_POST['task_name']; // Имя задачи
            $task_description = clean($_POST['description']); // Описание задачи
            $user_id = $_POST['user_id']; // Id ответственного
            $date = $_POST['date']; // Дата выполнения
            $time = $_POST['time']; // Время выполнения
            $dead_line = $date . " " . $time; // Дату и время заносим в один столбец БД

            // Имя и логин назначенного пользователя для отправки email админу
            $user_data =  getUser($user_id)[0];
            $user_name = $user_data["user_name"];
            $user_login = $user_data["login"];

            // Если задача редактируется, дату оставляем прежней
            if (empty($_POST['date']) || empty($_POST['time'])) {
                $dead_line = $_POST['dead_line'];
            }

            // Если не ввели время или дату при создании задачи, просим ввести
            if (empty($dead_line) || strlen($dead_line) < 10) {
                $response = 'Введите время и дату';
            }else{
                // Добавляем или редактируем задачу
                $response = setTask($task_id, $task_name, $task_description, $user_id, $dead_line);
            }

            // Информацию о назначении или редактировании задачи, отправляем на email админа и в telegram:
            $message = getMessage($response, $user_name, $user_login, $task_name, $dead_line);
            sendEmail($message);
            sendTelegramMessage($message);

            // Если создана новая задача, определяем её Id
            if ($response == 'Задача добавлена') {
                $task_id = getLastInsertedTaskId();
                header("location: index.php?c=page&act=one&id_task=" . $task_id); // Переходим на страницу этой задачи

            // Иначе если задача редактировалась, переходим на страницу этой задачи
            }else if ($response == 'Задача отредактирована'){
                header("location: index.php?c=page&act=one&id_task=" . $task_id); // Переходим на страницу этой задачи
            }

        }

        // Выводим шаблон страницы
        $this->content = $this->Template('../views/v_create.php',
            // Переменные для шаблона:
            array(
                'create_or_update' => $create_or_update,
                'usersData' => $usersData,
                'response' => $response,
                'date' => $date,
                'time' => $time,
                'task_id' => $task_id,
                'task_name' => $task_name,
                'task_description' => $task_description,
                'status_name' => $status_name,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'created_at' => $created_at,
                'dead_line' => date('Y-m-d H:i', $dead_line) // Преобразуем из Unix срок выполнения
                ));
    }

    // Страница задачи
    public function action_one(){
        $this->title .= 'Карточка задачи';

        // Принажатии на кнопку "Выполнена/Невыполнена" меняем статус задачи
        if (isset($_GET['completed']) && isset($_GET['id_task'])){
            $task_id = $_GET['id_task']; // Id задачи
            $status_name = (completedTask($task_id, $_GET['completed']) == 1) ? 'Не выполнена' : 'Выполнена'; // Текст для кнопки о смене статуса
        }

        // Получаем данные задачи
        if (isset($_GET['id_task'])){
            $task_data = getTask($_GET['id_task']);
            $task_data_item = $task_data['0'];
            $task_id = $task_data_item['task_id'];
            $task_name = $task_data_item['task_name'];
            $task_description = $task_data_item['description'];
            $user_name = $task_data_item['user_name'];
            $user_login = $task_data_item['login'];
            $id_status = $task_data_item['id_status'];
            $status_name = $task_data_item['status_name'];
            $created_at = $task_data_item['created_at'];
            $dead_line = $task_data_item['dead_line'];

            // Удаление задачи
            if (isset($_GET['delete']) && $_GET['delete'] == 'on'){
                $response = deleteTask($task_id); // Функция удаления задачи
                header('location: index.php'); // Переходим на главную страницу
            }
        }

        // Шаблон страницы
        $this->content = $this->Template('../views/v_task_item.php', array(
                // Переменные для шаблона
                'task_id' => $task_id,
                'task_name' => $task_name,
                'task_description' => $task_description,
                'status_name' => $status_name,
                'id_status' => $id_status,
                'user_login' => $user_login,
                'user_name' => $user_name,
                'created_at' => $created_at,
                'dead_line' => $dead_line,
        ));
    }

    // Страница регистрации пользователя
    public function action_registration(){
        $this->title .= 'Регистрация'; // Заголовок
        $response = "";

        // Получаем данные пользователя из формы
        if ($this->isPost()){
            $user_name = $_POST['name'];
            $user_login = $_POST['login'];
            $user_email = $_POST['email'];

            // Проверяем все ли поля заполнены
        if (empty($_POST['name']) || empty($_POST['login']) ||
                empty($_POST['password']) || empty($_POST['email'])
            ){
                $response = "Вы заполнили не все поля";
            }
        }

        // Валидация для email
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $response = 'email указан неверно!';
        }
        // Проверяем login на уникальность
        else if(!empty($_POST['name']) && !empty($_POST['login']) &&
            !empty($_POST['password']) && !empty($_POST['email'])
            && checkExistedLogin()){ // Функция проверки логина на уникальность
            $response = "Пользователь с таким логином уже существует";
        }
        // Заносим данные нового пользователя в БД
        else if (!empty($_POST['name']) && !empty($_POST['login']) &&
            !empty($_POST['password']) && !empty($_POST['email'])){
            $response = setUser(); // Функция создания нового пользователя
            header("location: /?res=registered"); // Переходим на главную страницу
        }

        // Шаблон страницы регистрацм
        $this->content = $this->Template('../views/v_registration.php',
            // Переменные для шаблона
            array(
                'user_name' => $user_name,
                'user_login' => $user_login,
                'user_email' => $user_email,
                'response' => $response
            ));
    }

    // Страница авторизации
    public function action_auth()
    {   $this->title .= 'Вход';

        // Если пользователь уже залогинен, переходим на главную
        if(alreadyLoggedIn()){
            header("Location: /");
        }

        // Если есть куки, то авторизуем сразу
        if(checkAuthWithCookie()){
            header("Location: /");
        }
        // Иначе пробуем авторизовать по логину и паролю
        else{
            $autherror = ''; // Переменная для вывода информации об ошибке
            if ($this->isPost()) {
                // Проверяем введён ли логин и пароль
                if (empty($_POST['login']) || empty($_POST['password'])) {
                    $autherror = "Введите логин и пароль";
                    unset($_SESSION["user"]);
                    session_destroy();
                }
                // Проверяем на соответсвие логин и пароль
                if (!authWithCredentials()) {
                    $autherror = 'Неправильный логин/пароль';
                    unset($_SESSION["user"]);
                    session_destroy();
                } else {
                   header("Location:  /");
                }
            }
        }
        $this->content = $this->Template('../views/v_auth.php',
            array('autherror' => $autherror));
    }

    // Разлогиниваем пользователя
    public function action_logout(){
        unset($_SESSION["user"]);
        session_destroy();
        header("Location: /");
    }
}
