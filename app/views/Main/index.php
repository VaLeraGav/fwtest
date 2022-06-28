<div class="container">
    <div id="answer"></div>
    <button class="btn btn-default" id="send">Кнопка</button>
    <br>
    
    <!-- настройка menu, переопределение -->
    <!-- <?php /*new \fw\widgets\menu\Menu([
        'tpl' => WWW . '/menu/my_menu.php',
        'container' => 'ul',
        'table' => 'categories',
        'cache' => 60,
        'class' => 'my-menu',
        'cacheKey' => 'menu_ul', 
        
    ]); */?> -->

    <!-- <?php /*new \fw\widgets\menu\Menu([
        'tpl' => WWW . '/menu/select.php',
        'container' => 'select',
        'table' => 'categories',
        'cache' => 60,
        'class' => 'my-select',
        'cacheKey' => 'menu_select',
    ]);*/ ?> -->


    <?php if (!empty($posts)) :
        foreach ($posts as $post) : ?>
            <div class='panel panel-default'>
                <div class='panel-heading'><?= $post['title'] ?></div>
                <div class='panel-body'><?= $post['text'] ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script src="/js/test.js"></script>
<script>
    // должен быть после подключения библиотеки jquery
    $(function() {
        $('#send').click(function() {
            $.ajax({
                url: '/main/test', // куда будет илти ajax запрос 
                type: 'post',
                data: {
                    'id': 2
                }, // данные которые хотим получить, пост с id=2 
                success: function(res) // при получении ответа 
                {
                    // вывод на экран массив
                    // var data = JSON.parse(res); // получение json обекта
                    // $('#answer').html('<p>ответ: '+ data.answer + '| Код: ' + data.code +'</p>');

                    $('#answer').html(res)
                    // console.log(res)
                },
                error: function() {
                    alert('Error');
                }
            });
        });
    });
</script>