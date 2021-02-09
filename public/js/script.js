(function (w, d) {
    function Module() {
        this._element = null;
        this._properties = {
            color: 'black',
            backgroundColor: 'white'
        };
    }

    Module.prototype.setProperty = function (name, value) {
        if (
            checkPropertyObject.call(this)
            && checkPropertyName.call(this, name)
            && checkPropertyValue.call(this, value)
        ) {
            this._properties[name] = value;
        }

        return this;
    };

    Module.prototype.init = function (selector) {
        this._element = d.querySelector(selector);

        checkElement.call(this);
    };

    Module.prototype.renderText = function (text) {
        checkElement.call(this);

        this._element.style.color = this._properties.color;
        this._element.style.backgroundColor = this._properties.backgroundColor;

        this._element.innerText = String(text);
    };

    function checkPropertyObject() {
        return typeof this._properties === 'object';
    }

    function checkPropertyName(name) {
        return typeof name === 'string';
    }

    function checkPropertyValue(value) {
        return typeof value === 'string';
    }

    function checkElement() {
        if (!(this._element instanceof HTMLElement)) {
            throw new Error('DOM Element not found');
        }
    }

    w.TextModule = new Module;
})(window, document);
