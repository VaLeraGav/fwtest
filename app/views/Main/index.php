<code><?= __FILE__ ?></code>

<div class="container">


    <?php if (!empty($posts)) :
        foreach ($posts as $post) : ?>
            <div class='panel panel-default'>
                <div class='panel-heading'><?= $post['title'] ?></div>
                <div class='panel-body'><?= $post['text'] ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>