<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php \vendor\core\base\View::getMeta()?>
    <title><?php //$meta['title'] ?> </title>


    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script >
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <div class="container">
        <h1>Admin</h1>
        <?php // debug($meta) 
        ?>
        <?php if (!empty($menu)) : // чтобы не выводил ошибки в отсутствии menu в main 
        ?>
            <ul class="nav nav-pills">
                <li><a href="page/about">About</a></li>
                <?php foreach ($menu as $item) : ?>
                    <li><a href="category/<?= $item['id'] ?>"><?= $item['title'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?= $content; ?>
        <!--  заметить что не <php а, убрали так как добавили RedBeans -->
        <?php // debug(vendor\core\Db::$countSql)
        ?>
        <?php // debug(vendor\core\Db::$queries)
        ?>
    </div>

    <!-- на jQuery (необходим для Bootstrap - х JavaScript плагины) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Включают все скомпилированные плагины (ниже), или включать отдельные файлы по мере необходимости -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <?php
    foreach ($scripts as $script) // проходит по массиву scripts, там то что сверху, он находиться в view
    {
        echo $script;
    }
    ?>
</body>

</html>