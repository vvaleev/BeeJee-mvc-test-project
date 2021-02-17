<?php use \System\Document\Page; ?>
<?php Page::renderCss('auth.form'); ?>
<?php Page::renderJs('task.form'); ?>
<?php Page::renderJs('auth.form'); ?>

<div class="auth-form">
    <form data-element="form-auth" action="/" method="post" enctype="application/x-www-form-urlencoded">
        <div class="form-group">
            <label for="inputLogin">Логин <span class="text-danger">*</span></label>
            <input data-element="form-login" type="text" name="login" class="form-control" id="inputLogin"
                   required="required" placeholder="Введите логин"/>
        </div>

        <div class="form-group">
            <label for="inputPassword">Пароль <span class="text-danger">*</span></label>
            <input data-element="form-password" type="password" name="password" class="form-control" id="inputPassword"
                   required="required" placeholder="Введите пароль"/>
        </div>

        <button data-element="form-auth-submit" type="button" class="btn btn-primary">Войти</button>
    </form>
</div>

<script>
    addEventListener('load', function () {
        Auth.Form.init();
    });
</script>
