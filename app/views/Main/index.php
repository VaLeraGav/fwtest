<div class="container">
    <button class="btn btn-default" id="send">Кнопка</button>
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
                    console.log(res)
                },
                error: function() {
                    alert('Error');
                }
            });
        });
    });
</script>