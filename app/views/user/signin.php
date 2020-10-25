<form class="form-signin" action="/login" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Пожалуйста авторизуйтесь</h1>

    <?php if (\app\lib\Flash::is_set('auth_fail')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= \app\lib\Flash::get('auth_fail') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errors) && $errors === false) : ?>
        <?php foreach ($validator->getMessages() as $attribute => $messages) : ?>
            <?php foreach ($messages as $message) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $message->getTemplate() ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <label for="username" class="sr-only">Имя пользователя</label>
    <input type="text" id="username" name="username" class="form-control" placeholder="Имя пользователя" required autofocus min="4" max="16">

    <label for="password" class="sr-only">Пароль</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Пароль" required min="4" max="16">

<!--    <div class="checkbox mb-3">-->
<!--        <label>-->
<!--            <input type="checkbox" name="remember" value="remember-me"> Запомнить-->
<!--        </label>-->
<!--    </div>-->

    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
</form>