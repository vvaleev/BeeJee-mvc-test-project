(function (w, d, $) {
    function Module() {
        this._uri = '/task/list/get/';
        this._element = null;
        this._data = [];
        this._columns = [];
        this._options = {};
    }

    Module.prototype.init = function (selector) {
        this._element = d.querySelector(selector);

        checkElement.call(this);
    };

    Module.prototype.setData = function (data) {
        if (checkData(data)) {
            this._data = data;
        }

        return this;
    };

    Module.prototype.setColumns = function (columns) {
        if (checkColumns(columns)) {
            this._columns = columns;
        }

        return this;
    };

    Module.prototype.setOption = function (name, value) {
        if (
            checkOptionObject.call(this)
            && checkOptionName.call(this, name)
            && checkOptionValue.call(this, value)
        ) {
            this._options[name] = value;
        }

        return this;
    };

    Module.prototype.renderData = function () {
        checkElement.call(this);

        if (checkData(this._data) && checkColumns(this._columns)) {
            $(this._element).DataTable(
                Object.assign({
                    data: this._data,
                    columns: this._columns,
                }, this._options)
            );
        }
    };

    Module.prototype.getData = function (callback) {
        $.ajax({
            url: this._uri,
            data: {
                IS_AJAX: true
            },
            dataType: 'json'
        }).done(function (response) {
            var data = [];

            if (typeof response === 'object' && response.data) {
                data = response.data;
            }

            typeof callback === 'function' && callback(data);
        });
    };

    function checkElement() {
        if (!(this._element instanceof HTMLElement)) {
            throw new Error('DOM Element not found');
        }
    }

    function checkData(data) {
        return !!(Array.isArray(data));
    }

    function checkColumns(columns) {
        return !!(Array.isArray(columns) && columns.length);
    }

    function checkOptionObject() {
        return typeof this._options === 'object';
    }

    function checkOptionName(name) {
        return typeof name === 'string';
    }

    function checkOptionValue(value) {
        return typeof value !== 'undefined';
    }

    w.Task = w.Task || {};
    w.Task.List = new Module;
})(window, document, jQuery);
