<?php
/**
 * Основной шаблон
 */
?>

<!-- Шаблон главной страницы -->
<div class="container">

    <!-- Кнопки для параметров сортировки -->
    <div class="sorting">
        <!-- navs -->
        <h1 id="page-title" class="display-4 py-3 my-3 text-center"><strong>ЗАДАЧИ</strong></h1>
        <nav id="sort-nav" class="navbar navbar-light nav justify-content-center nav-pills flex-column flex-sm-row nav-sort">
            <li><h5 id="sorting-title">СОРТИРОВКА</h5></li>
            <li><a id="sort_user_name" class="nav-link" href="?sort=<?=$sort_user_name?>"><?=$nav_title_sort_user_name?></a></li>
            <li><a id="sort_deadline" class="nav-link" href="?sort=<?=$sort_date?>"><?=$nav_title_sort_date?></a></li>
            <li><a id="sort_status" class="nav-link" href="?sort=<?=$sort_status?>"><?=$nav_title_sort_status?></a></li>
        </nav>
    </div>

    <!-- Выводим превью задач -->
    <!-- cards -->
    <div id="row-tasks" class="row">
        <?
        foreach($tasks as $task){
            ?>
            <div id="column_task_<?=$task['task_id']?>"
                class="col-md-6 col-lg-4 task-column task-cards list-group"
                data-toggle="modal" data-target="#taskModal"
                data-sortUser = "<?=$task['user_name']?>"
                data-sort-deadline = "<?=$task['dead_line']?>"
                data-sortStatus = "<?=$task['status_name']?>">

                <!-- Ссылка для вывода модального окна задачи -->
                <a class="task-href list-group-item-heading active" id="href_task_<?=$task['task_id']?>" href="?act=one&id_task=<?=$task['task_id']?>">
                    <div class="card" id="card_task_<?=$task['task_id']?>">
                        <div class="card-body" id="body_task_<?=$task['task_id']?>">
                            <h3 id="title_task_<?=$task['task_id']?>" class="card-title"><?=$task['task_name']?></h3>

                            <!-- Описание задачи -->
                            <p id="description_task_<?=$task['task_id']?>"><?=$task['description']?></p>

                            <!-- Ответсвенный -->
                            <p id="user_task_<?=$task['task_id']?>">Ответственный:
                                <span id="username_task_<?=$task['task_id']?>"> <?=$task['user_name']?></span></p>

                            <!-- Срок выполнения -->
                            <p id="deadline_task_<?=$task['task_id']?>">Срок выполнения:
                                <span id="deadline-span_task_<?=$task['task_id']?>"> <?=date('Y-m-d H:i', $task['dead_line'])?></span></p>

                            <!-- Ставим пометку, если задача выполнена -->
                            <img id="status_task_<?=$task['task_id']?>" src="
                            <? if ($task['id_status'] == 1) {
                                echo "img/completed.png";
                            }else{
                                echo "img/uncompleted.png";
                            }
                            ?>
                            " width="20" alt="completed">
                        </div>
                    </div>
                </a>
            </div>
            <?;
        }?>
    </div>

    <!-- Кнопки для пагинации -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?
            // Кнопка "Предыдущая страница"
            // Если находимся на первой странице, делаем кнопку нерабочей
            if($page <= 1){
                echo
                '<li id="li_previous_page" class="page-item">
                    <a id="previous-page" class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span></a>
                    </li>';
            }
            // Иначе в ссылке передаём get-рараметры для перехода на предыдущую страницу
            else{
                echo
                    '<li id="li_previous_page" class="page-item">
                <a id="previous-page" class="page-link" href="index.php
                    ?page=' . ($page-1) .
                    '&first_result=' . ($page-2)*$results_per_page .
                    '&result_per_page=' . $results_per_page .
                    '&sort=' . $_GET['sort'] .
                    '&order='. $order .
                    '" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span></a>
            </li>'
                ;}?>

            <?
            // Выводим номера страниц
            for ($page=1;$page<=$count_pages;$page++){
                // Выделяем активную страницу
                if (!isset($_GET['page'])){
                    if ($page == 1){
                        $active = 'active';
                    }else{
                        $active = ' ';
                    }
                }else if ($_GET['page'] == $page){
                    $active = 'active';
                }else{
                    $active = ' ';
                }

                echo '<li id="li_page_numbers" class="page-item ' . $active . '">
                <a class="page-link" href="index.php?page=' . $page .
                    '&first_result=' . ($page-1)*$results_per_page .
                    '&result_per_page=' . $results_per_page .
                    '&sort=' . $_GET['sort'] .
                    '&order='. $order .
                    '" class="btn">' . $page . '</a>
                </li>';
            }
            ?>

            <?
            // Кнопка "Следующая страница"
            $page = (!isset($_GET['page'])) ? 1 : $_GET['page'];
            // Если находимся на последней странице, делаем кнопку нерабочей
            if($page >= $count_pages){
                echo
                '<li id="li_next_page" class="page-item">
                    <a id="next-page" class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span></a>
                    </li>';
            }
            // Иначе, передаём в ссылке get-параметры для перехода на следующую страницу
            else{
                echo
                    '<li id="li_next_page" class="page-item">
                <a id="next-page" class="page-link" href="index.php
                    ?page=' . ($page+1) .
                    '&first_result=' . ($page-1)*$results_per_page .
                    '&result_per_page=' . $results_per_page .
                    '&sort=' . $_GET['sort'] .
                    '&order='. $order .
                    '" aria-label="Previous">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span></a>
            </li>'
                ;}?>
        </ul>
    </nav>
</div>

<!-- Модальное окно -->
<?=$modal?>

