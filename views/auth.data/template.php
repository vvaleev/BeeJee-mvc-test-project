<?php use \System\Document\Page; ?>
<?php Page::renderCss('auth.data'); ?>

<div class="text-center auth-data">
    <span><?php echo $data['first_name']; ?></span>
    <span>&nbsp;</span>
    <span><?php echo $data['last_name']; ?></span>
    <a class="btn btn-primary btn-xs auth-data__btn-logout" href="/auth/logout/">
        Выйти
    </a>
</div>
