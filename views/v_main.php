<?php
/**
 * Основной шаблон
 * ===============
 * $title - заголовок
 * $content - HTML страницы
 */
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$title?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/main_index_style.css">
    <link rel="stylesheet" type="text/css" href="css/registration_auth_style.css">
    <link rel="stylesheet" type="text/css" href="css/navigation_style.css">
    <link rel="stylesheet" type="text/css" href="css/create_update_task_style.css">
</head>

<body>
<header>
    <!-- navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark">

        <div class="container">

            <div id="logo"></div>
            <div id="companyName">ЗАДАЧНИК</div>

            <!-- Иконка для меню на малых размерах экрана -->
            <button class="navbar-toggler" data-toggle="collapse" data-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Кнопки в меню -->
            <div class="collapse navbar-collapse" id="mainNav">
                <div class="nav navbar-nav">
                    <a class="nav-item nav-link <?=$index_active?>" href="index.php?c=page&act=index">Главная</a>
                    <a class="nav-item nav-link <?=$create_active?>" href="index.php?c=page&act=create">Создать задачу</a>
                </div>
            </div>

            <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                <div class="nav navbar-nav">
                    <button class="btn btn-outline-success navbar-btn btn-sm <?=$auth_active?>"
                    style="margin-left: 10px">
                        <a class="nav-item nav-link" href="index.php?c=page&act=<?=$auth?>"><?=$login?></a>
                    </button>

                    <button class="btn btn-outline-info navbar-btn btn-sm <?=$registration_active?>"
                    style="margin-left: 10px">
                        <a class="nav-item nav-link" href="index.php?c=page&act=registration">Регистрация</a>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Страницы сайта -->
	<div class="content">
		<?=$content?>
	</div>

</body>

<footer>
    <div>Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
    <p id="copyright" class="copyright">&#169 Все права защищены</p>
</footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Файлы JS -->
    <script src="js/utilities.js"></script>
    <script src="js/index.js"></script>
    <script src="js/modal-values.js"></script>
    <script src="js/edit_form.js"></script>
    <script src="js/edit_title_post.js"></script>
    <script src="js/edit_description_post.js"></script>
    <script src="js/edit_user_post.js"></script>
    <script src="js/edit_deadline_post.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/tasks_sort.js"></script>
</html>
