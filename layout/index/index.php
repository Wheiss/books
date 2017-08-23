<?=render(ROOT . '/layout/blocks/header.php')?>
<a href="<?= Router::url('signOut') ?>">Выход</a>
<center>
<?=$content?>
</center>
</body>
</html>