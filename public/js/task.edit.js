(function (w, d, $) {
    function Module() {
        /* Наследование свойств и методов с Task.Form-объекта */
        Task.Form.apply(this, arguments);

        this._uriGet = '/task/get/';
        this._uriSave = '/task/edit/';
        this._idRecord = 0;

        this._$modal = null;
        this._$modalCloseBtn = null;
    }

    /* Наследование prototype-методов с Task.Form-объекта */
    Module.prototype = Object.create(Task.Form.prototype);
    Module.prototype.constructor = Module;

    Module.prototype.init = function () {
        this.initForm('form-edit');

        this._$modal = $('#editTask');
        checkElement(this._$modal);

        this._$modalCloseBtn = this._$modal.find('[data-dismiss="modal"]');

        this.adminBtnsInit();
    };

    Module.prototype.adminBtnsInit = function () {
        var _this = this;

        $(d).on('click', '[data-edit-id]', function (evt) {
            evt.preventDefault();

            var id = $(this).data('edit-id');

            if (id) {
                _this._idRecord = id;

                _this.getDataById(id, function (result) {
                    _this.setDataToForm(result);
                });
            }
        });
    };

    Module.prototype.formSubmit = function (formData, options) {
        var _this = this;

        formData.append('IS_AJAX', true);

        $.ajax({
            url: _this._uriSave + _this._idRecord + '/?IS_AJAX=true',
            type: options.method,
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
        }).done(function (response) {
            if (typeof response === 'object' && response.result) {
                _this._$modalCloseBtn.trigger('click');

                /* Task.List.getDataTableInstance().destroy();
                Task.List.getData(function (data) {
                    Task.List.setData(data);
                    Task.List.renderData();
                }); */

                w.location.reload();
            }
        });

        _this._idRecord = 0;
    };

    Module.prototype.getDataById = function (id, callback) {
        var _this = this;

        $.ajax({
            url: _this._uriGet + id + '/?IS_AJAX=true',
            type: 'get',
            dataType: 'json',
        }).done(function (response) {
            if (typeof response === 'object' && response.result) {
                typeof callback === 'function' && callback(response.result);
            }
        });
    };

    Module.prototype.setDataToForm = function (data) {
        if (typeof data !== 'object') {
            return false;
        }

        if (data.name) {
            this.name(data.name);
        }

        if (data.description) {
            this.description(data.description);
        }

        if (data.email) {
            this.email(data.email);
        }

        if (data.status) {
            this.status(data.status);
        }
    };

    function checkElement($element) {
        if (typeof $element !== 'object' || $element.length !== 1 || !($element.get(0) instanceof HTMLElement)) {
            throw new Error('DOM Element not found');
        }
    }

    w.Task = w.Task || {};
    w.Task.Edit = new Module;
})(window, document, jQuery);
