<?php use \System\Document\Page; ?><!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>

    <?php Page::renderCss('fonts'); ?>
    <?php Page::renderCss('bootstrap.min'); ?>
    <?php Page::renderCss('style'); ?>
    <?php Page::renderJs('jquery-3.3.1.min'); ?>
    <?php Page::renderJs('bootstrap.min'); ?>
    <?php Page::renderJs('script'); ?>

</head>
<body>
    <div class="container-fluid">
        <header class="row bg-primary">
            <div class="col-xs-1">
                <div class="header__logo-block">
                    <a href="/">
                        <img src="<?php echo SITE_PUBLIC_DIR_NAME; ?>/images/logo.png" alt="Logo" class="header__logo"/>
                    </a>
                </div>
            </div>
            <div class="col-xs-11">
                <div class="header-title">
                    Управление задачами
                </div>
            </div>
        </header>
        <main class="row">
