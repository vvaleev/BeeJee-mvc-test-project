<?php use System\View; ?>
<?php View::renderView('header') ?>
<div class="col-xs-12">
    <?php View::renderView('task.list') ?>
    <?php View::renderView('task.add') ?>
    <?php View::renderView('task.edit') ?>
</div>
<?php View::renderView('footer') ?>
