<?php use System\View; ?>
<?php View::renderView('header') ?>
<div id="text-workarea"></div>
<script>
    addEventListener('load', function () {
        TextModule.setProperty('color', '#15824f').setProperty('backgroundColor', '#fbfbfb')

        TextModule.init('#text-workarea');
        TextModule.renderText('Document is Ready');
    });
</script>
<?php View::renderView('footer') ?>
