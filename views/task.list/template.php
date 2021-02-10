<?php use \System\Document\Page; ?>
<?php Page::renderCss('task.list'); ?>
<?php Page::renderJs('task.list'); ?>

<div class="task-list">
    <table class="display" id="task-list"></table>
</div>

<script>
    addEventListener('load', function () {
        Task.List.init('#task-list');

        Task.List
            .setOption('pageLength', 3)
            .setOption('paging', true);

        $.ajax({
            url: '/task/list/get/',
            data: {
                IS_AJAX: true
            },
            dataType: 'json'
        }).done(function (response) {
            if (typeof response === 'object') {
                response.COLUMNS && Task.List.setColumns(response.COLUMNS)
                response.DATA && Task.List.setData(response.DATA);
            }

            Task.List.renderData();
        });
    });
</script>
