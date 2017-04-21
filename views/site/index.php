<?php include ROOT . '/views/lego/header.php'; ?>
        
        <div class="container">
            <div class="row">
                <h1>Парсер Lenta.ru</h1>
                <a class="btn btn-default" href="/add" role="button">
                    <i class="glyphicon glyphicon-import"></i>  Получить последние новости
                </a>
                <a class="btn btn-default" href="/csv" role="button">
                    <i class="glyphicon glyphicon-export"></i>  Экспорт
                </a>
            </div>
        </div>
        <div class="container">
            <?php foreach ($news_list as $news): ?>
                <div class="row">
                    <h4><?php echo $news['title']; ?></h4>
                    <p>
                        <?php echo mb_strimwidth($news['description'], 0, 203, '...'); ?>
                        <a class="btn btn-default btn-xs" href="/news/<?php echo $news['id']; ?>" role="button">
                            Подробнее
                        </a>
                    </p>
                    <small><?php echo date('r', $news['pubdate']); ?></small>
                    <br><hr>
                </div>
            <?php endforeach ?>
        </div>

<?php include ROOT . '/views/lego/footer.php'; ?>
