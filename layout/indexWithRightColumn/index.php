<?=render(ROOT . '/layout/blocks/header.php')?>
<a href="<?= Router::url('signOut') ?>">Выход</a>

<div class="main-container">
    <div class="main-column"><?= $content ?></div>
    <div class="right-column">
        <?= Application::getInstance()->getExecutionTime(); ?>
        <?= render(ROOT . '/layout/blocks/randomBooks.php') ?>
        <?= render(ROOT . '/layout/blocks/topBooks.php') ?>
        <div class="execution-time">
            Время выполнения: <?= round(Application::getInstance()->getExecutionTime(), 3); ?>
        </div>
    </div>
</div>
</body>
</html>