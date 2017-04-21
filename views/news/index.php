<?php include ROOT . '/views/lego/header.php'; ?>

<div class="container">
    <div class="row">
        <h1>Парсер Lenta.ru</h1>
        <a class="btn btn-default" href="/" role="button">
            <i class="glyphicon glyphicon-home"></i>  Вернуться к списку новостей
        </a>
    </div>
</div>
<div class="container">
    <h2><?php echo $news['title']; ?></h2>
    
    <img src="<?php echo $news['image']; ?>">
    <?php foreach (json_decode($news['text']) as $paragraph): ?>
        <p><?php echo $paragraph; ?></p>
    <?php endforeach ?>
    <small><?php echo date('r', $news['pubdate']); ?></small>
    <br><hr>
</div>

<?php include ROOT . '/views/lego/footer.php'; ?>