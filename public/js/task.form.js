(function (w, d, $) {
    function Module() {
        this._$formElement = null;
        this._$formNameElement = null;
        this._$formDescriptionElement = null;
        this._$formEmailElement = null;
        this._$formStatusElement = null;
        this._$formSubmitElement = null;
    }

    Module.prototype.initForm = function (formId) {
        var _this = this;

        this._$formElement = $('[data-element="' + formId + '"]');
        checkElement(this._$formElement);

        this._$formNameElement = this._$formElement.find('[data-element="form-name"]');
        checkElement(this._$formNameElement);

        this._$formDescriptionElement = this._$formElement.find('[data-element="form-description"]');
        checkElement(this._$formDescriptionElement);

        this._$formEmailElement = this._$formElement.find('[data-element="form-email"]');
        checkElement(this._$formEmailElement);

        this._$formStatusElement = this._$formElement.find('[data-element="form-status"]');
        checkElement(this._$formStatusElement);

        this._$formSubmitElement = $('[data-element="' + formId + '-submit"]');
        checkElement(this._$formSubmitElement);

        this._$formElement.on('submit', function (evt) {
            evt.preventDefault();

            var formData = new FormData(_this._$formElement.get(0));
            var status = true;

            resetErrorStatuses.call(_this);

            formData.forEach(function (value, key) {
                if (!validate.call(_this, key)) {
                    setErrorStatus.call(_this, key);

                    status = false;
                }
            });

            status && typeof _this.formSubmit === 'function' && _this.formSubmit(
                formData,
                {
                    url: _this._$formElement.prop('action'),
                    method: _this._$formElement.prop('method'),
                    dataType: _this._$formElement.prop('enctype'),
                }
            );
        });

        this._$formSubmitElement.on('click', function (evt) {
            evt.preventDefault();

            _this._$formElement.submit();
        });
    };

    Module.prototype.name = function (value) {
        if (value) {
            return set.apply(this, [this._$formNameElement, value]);
        }

        return get.call(this, this._$formNameElement);
    };

    Module.prototype.description = function (value) {
        if (value) {
            return set.apply(this, [this._$formDescriptionElement, value]);
        }

        return get.call(this, this._$formDescriptionElement);
    };

    Module.prototype.email = function (value) {
        if (value) {
            return set.apply(this, [this._$formEmailElement, value]);
        }

        return get.call(this, this._$formEmailElement);
    };

    Module.prototype.status = function (value) {
        if (value) {
            return set.apply(this, [this._$formStatusElement, value]);
        }

        return get.call(this, this._$formStatusElement);
    };

    function checkElement($element) {
        if (typeof $element !== 'object' || $element.length !== 1 || !($element.get(0) instanceof HTMLElement)) {
            throw new Error('DOM Element not found');
        }
    }

    function get($element) {
        checkElement($element);

        return $element.val();
    }

    function set($element, value) {
        checkElement($element);

        $element.val(value);

        return true;
    }

    function resetErrorStatuses() {
        this._$formNameElement.css({border: ''});
        this._$formDescriptionElement.css({border: ''});
        this._$formEmailElement.css({border: ''});
        this._$formStatusElement.css({border: ''});
    }

    function setErrorStatus(key) {
        var borderPropertyValue = '1px solid #a94442';

        switch (key) {
            case 'name':
                this._$formNameElement.css({border: borderPropertyValue});
                break;
            case 'description':
                this._$formDescriptionElement.css({border: borderPropertyValue});
                break;
            case 'email':
                this._$formEmailElement.css({border: borderPropertyValue});
                break;
            case 'status':
                this._$formStatusElement.css({border: borderPropertyValue});
                break;
        }
    }

    function validate(key) {
        switch (key) {
            case 'name':
                return !(this._$formNameElement.prop('required') && !this.name());
            case 'description':
                return !(this._$formDescriptionElement.prop('required') && !this.description());
            case 'email':
                return !(this._$formEmailElement.prop('required') && !this.email());
            case 'status':
                return !(this._$formStatusElement.prop('required') && !this.status());
        }

        return true;
    }

    w.Task = w.Task || {};
    w.Task.Form = Module;
})(window, document, jQuery);
