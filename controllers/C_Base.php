<?php
// Подключаем шаблонизатор
include_once('Controller.php');

//
// Контроллер базового шаблона
//
abstract class C_Base extends Controller
{
	protected $title;		// Заголовок страницы
	protected $content;		// Содержание страницы внутри базового шаблона
    protected $login;       // Кнопка вход/выход
    protected $auth;        // Get-параметр для входа/выхода
    protected $reg;         // Кнопка Регистрация
    protected $active_href;      // Выделение активной ссылки в главном меню

	//
	// Конструктор.
	//
	function __construct()
	{
	    $this->title = '';

	    // Переменные для кнопок меню сайта:
        $this->login = 'Войти';
        $this->auth = 'auth';
        $this->reg = 'Регистрация';

        // Содержимое страницы внутри базового шаблона
        $this->content = '';

        // Отображение активной страницы в меню
        $this->active_href = (isset($_GET['act'])) ? $_GET['act'] . '_active' : 'index_active';

        // Убираем выделение активной ссылки если оно не нужно
        if (isset($_GET['edit'])){
           unset($this->active_href);
        }

        // Если
        if(isset($_SESSION['user'])){
            $this->auth = 'logout';
            $this->login = 'Выйти';
        }
	}
	
	// Генерация базового шаблона
	public function render()
	{
	    // Значения переменных
		$vars = array(
		    "$this->active_href" => 'active',
		    'title' => $this->title,
            'login' => $this->login,
            'auth' => $this->auth,
            'reg' => $this->reg,
            'content' => $this->content,
        );
		// Генерация HTML
		$page = $this->Template('../views/v_main.php', $vars);
		echo $page;
	}	
}
