<center>
    <form action="<?=Router::url('signIn')?>" method="post" class="auth-form">
        <?php if (!empty($authorisationErrors)) : ?>
            <? foreach ($authorisationErrors as $name => $text) : ?>
                <?= "<p class='error'>$text</p>" ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <p>Ваш логин:
            <input class="input-text" type="text" name="login" value="<?= htmlspecialchars(@$_POST['login']) ?>"/>
        </p>
        <p>Пароль:
            <input class="input-text" type="password" name="password"
                   value="<?= htmlspecialchars(@$_POST['password']) ?>"/>
        </p>
        <p>
            <input type="submit" value="Войти"/>
        </p>

    </form>
</center>