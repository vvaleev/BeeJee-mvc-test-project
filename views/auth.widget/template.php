<?php use \System\Document\Page; ?>
<?php Page::renderCss('auth.widget'); ?>

<div class="text-center auth-data">
    <?php if (!empty($data)) { ?>
        <span><?php echo $data['first_name']; ?></span>
        <span>&nbsp;</span>
        <span><?php echo $data['last_name']; ?></span>
        <a class="btn btn-primary btn-xs auth-data__btn-logout" href="/auth/logout/">
            Выйти
        </a>
        <?php } else { ?>
        <a class="btn btn-primary btn-xs auth-data__btn-auth" href="/auth/login/form/">
            Авторизоваться
        </a>
        <?php } ?>
</div>
