(function (w, d, $) {
    function Module() {
        this._uri = '/auth/login/';

        this._$formElement = null;
        this._$formLoginElement = null;
        this._$formPasswordElement = null;
        this._$formSubmitElement = null;
    }

    Module.prototype.init = function () {
        var _this = this;

        this._$formElement = $('[data-element="form-auth"]');
        checkElement(this._$formElement);

        this._$formLoginElement = this._$formElement.find('[data-element="form-login"]');
        checkElement(this._$formLoginElement);

        this._$formPasswordElement = this._$formElement.find('[data-element="form-password"]');
        checkElement(this._$formPasswordElement);

        this._$formSubmitElement = $('[data-element="form-auth-submit"]');
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
                    uri: _this._uri,
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

    Module.prototype.formSubmit = function (formData, options) {
        formData.append('IS_AJAX', true);

        $.ajax({
            url: options.uri,
            type: options.method,
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'json',
        }).done(function (response) {
            if (typeof response === 'object' && response.result) {
                w.location.pathname = '/';
            } else {
                alert('Authorization failed');
            }
        });
    };

    function checkElement($element) {
        if (typeof $element !== 'object' || $element.length !== 1 || !($element.get(0) instanceof HTMLElement)) {
            throw new Error('DOM Element not found');
        }
    }

    function resetErrorStatuses() {
        this._$formLoginElement.css({border: ''});
        this._$formPasswordElement.css({border: ''});
    }

    function setErrorStatus(key) {
        var borderPropertyValue = '1px solid #a94442';

        switch (key) {
            case 'login':
                this._$formLoginElement.css({border: borderPropertyValue});
                break;
            case 'password':
                this._$formPasswordElement.css({border: borderPropertyValue});
                break;
        }
    }

    function validate(key) {
        switch (key) {
            case 'login':
                return !(this._$formLoginElement.prop('required') && !this._$formLoginElement.val());
            case 'password':
                return !(this._$formPasswordElement.prop('required') && !this._$formPasswordElement.val());
        }

        return true;
    }

    w.Auth = w.Auth || {};
    w.Auth.Form = new Module;
})(window, document, jQuery);
