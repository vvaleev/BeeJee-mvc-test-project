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
            .setOption('paging', true)
            .setOption('searching', true)
            .setOption('ordering', true);

        Task.List.setColumns([
            {title: 'Название задачи'},
            {title: 'Описание задачи'},
            {title: 'Автор задачи'},
            {title: 'E-mail автора задачи'},
            {title: 'Статус задачи'},
        ]);

        Task.List.getData(function (data) {
            Task.List.setData(data);
            Task.List.renderData();
        });
    });
</script>
