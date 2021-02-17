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
            .setOption('ordering', true)
            .setOption('order', [[0, 'desc']]);

        Task.List.getData(function (data) {
            var columns = [
                {title: 'ID'},
                {title: 'Название задачи'},
                {title: 'Описание задачи'},
                {title: 'Автор задачи'},
                {title: 'E-mail автора задачи'},
                {title: 'Статус задачи'},
            ];

            if (Array.isArray(data) && typeof data[0] === 'object') {
                if (data[0][Object.keys(data[0]).length - 1] === 'operations') {
                    columns.push({title: 'Операции'});

                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            data[key].pop();
                            data[key].push(
                                '<a href="/task/remove/' + data[key][0] + '/">Удалить</a>' +
                                '&nbsp;' +
                                '<a href="/task/edit/' + data[key][0] + '/">Редактировать</a>'
                            );
                        }
                    }
                }
            }

            Task.List.setColumns(columns);
            Task.List.setData(data);
            Task.List.renderData();
        });
    });
</script>
