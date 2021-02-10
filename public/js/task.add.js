(function (w, d, $) {
    function Module() {
        /* Наследование свойств и методов с Task.Form-объекта */
        Task.Form.apply(this, arguments);

        this._$modal = null;
        this._$modalCloseBtn = null;
    }

    /* Наследование prototype-методов с Task.Form-объекта */
    Module.prototype = Object.create(Task.Form.prototype);
    Module.prototype.constructor = Module;

    Module.prototype.init = function () {
        this.initForm('form-add');

        this._uri = '/task/add/';

        this._$modal = $('#addTask');
        checkElement(this._$modal);

        this._$modalCloseBtn = this._$modal.find('[data-dismiss="modal"]');
    };

    Module.prototype.formSubmit = function (formData, options) {
        var _this = this;

        formData.append('IS_AJAX', true);

        $.ajax({
            url: this._uri,
            type: options.method,
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
        }).done(function (response) {
            if (typeof response === 'object' && response.result) {
                _this._$modalCloseBtn.trigger('click');

                Task.List.getDataTableInstance().destroy();
                Task.List.getData(function (data) {
                    Task.List.setData(data);
                    Task.List.renderData();
                });
            }
        });
    };

    function checkElement($element) {
        if (typeof $element !== 'object' || $element.length !== 1 || !($element.get(0) instanceof HTMLElement)) {
            throw new Error('DOM Element not found');
        }
    }

    w.Task = w.Task || {};
    w.Task.Add = new Module;
})(window, document, jQuery);
