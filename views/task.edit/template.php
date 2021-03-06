<?php use \System\Document\Page; ?>
<?php Page::renderCss('task.edit'); ?>
<?php Page::renderJs('task.form'); ?>
<?php Page::renderJs('task.edit'); ?>

<div class="modal fade" id="editTask" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Изменение задачи</h4>
            </div>
            <div class="modal-body">
                <form data-element="form-edit" action="/" method="post"
                      enctype="application/x-www-form-urlencoded">
                    <div class="form-group">
                        <label for="inputName">Название <span class="text-danger">*</span></label>
                        <input data-element="form-name" type="text" name="name" class="form-control" id="inputName"
                               required="required" placeholder="Название"/>
                    </div>
                    <div class="form-group">
                        <label for="textareaDescription">Описание <span class="text-danger">*</span></label>
                        <textarea data-element="form-description" name="description" id="textareaDescription" cols="30"
                                  rows="10" class="form-control" required="required" placeholder="Описание"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">E-mail <span class="text-danger">*</span></label>
                        <input data-element="form-email" type="email" name="email" class="form-control" id="inputEmail"
                               required="required" placeholder="E-mail"/>
                    </div>
                    <div class="form-group">
                        <label for="selectStatus">Статус <span class="text-danger">*</span></label>
                        <select data-element="form-status" name="status" id="selectStatus" class="form-control"
                                required="required">
                            <option value="1" selected="selected">Не выполнено</option>
                            <option value="2">В работе</option>
                            <option value="3">Выполнено</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button data-element="form-edit-submit" type="button" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script>
    addEventListener('load', function () {
        Task.Edit.init();
    });
</script>
