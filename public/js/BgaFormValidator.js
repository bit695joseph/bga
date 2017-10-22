/**
 * Validates a form according to the rules passed in to init()
 * Uses jQuery.
 */
var BgaFormValidator = (function () {

    var $form, $errorList, fields = [], errors = {};

    // Field Class ========================================
    var Field = function (opts, containerSelector) {

        this.$el = $('#' + opts.id, $form);
        this.$container = this.$el.closest(containerSelector);
        this.$errorItem = $('<li>');
        this.name = this.$el.attr('name');
        this.descriptor = opts.descriptor || this.$el.attr('title');
        this.rules = opts.rules;
        this.message = null;
        this.value = null;
        this.trimmedValue = null;
        this.validatesOnChange = false;
    };

    Field.prototype.startValidatingOnChange = function (validateFieldFn) {
        if (this.validatesOnChange === false) {

            this.validatesOnChange = true;

            this.$el.on('change input', $.proxy(
                function () {
                    validateFieldFn(this);
                },
                this
            ));
        }
    };

    Field.prototype.displayErrorMessage = function () {

        //if (this.$errorList[0].contains())
        this.$errorItem.remove();
        this.$errorItem.text(this.message);
        this.$errorItem.appendTo($errorList);
    }


    Field.prototype.removeErrorMessage = function () {
        this.$errorItem.remove();
    }

    Field.prototype.addErrorClassToContainer = function () {
        this.$container.addClass('invalid');
    }

    Field.prototype.removeErrorClassFromContainer = function () {
        this.$container.removeClass('invalid');
    }

    Field.prototype.getResult = function (valid, msg) {
        return valid ? true : this.descriptor + ' ' + msg;
    }

    Field.prototype.validators = {
        required: function (required) {

            if (required === false) return true;

            return this.getResult(
                this.trimmedValue.length > 0, "is required");
        },
        minlength: function (minlength) {
            return this.getResult(
                this.trimmedValue.length >= minlength,
                "must have at least " + minlength + " character(s)");
        },
        maxlength: function (maxlength) {
            return this.getResult(
                this.trimmedValue.length <= maxlength,
                "cannot exceed " + maxlength + " character(s)");
        },
        pattern: function (regex) {

            return this.getResult(
                this.value.search(regex) > -1,
                " is not in the correct format.");
        },
        custom: function (opts) {
            return this.getResult(
                opts.validate(this.value), opts.message || "is not valid");
        }
    };

    Field.prototype.runRule = function (ruleName) {
        var validatorFunc = this.validators[ruleName],
            params = this.rules[ruleName];
        return validatorFunc.apply(this, [params]);
    };

    Field.prototype.validate = function () {

        var rule, result;

        this.message = null;
        this.value = this.$el.val();
        this.trimmedValue = $.trim(this.value);

        for (rule in this.rules) {
            if (this.rules.hasOwnProperty(rule)) {

                // Run the validator for this rule.
                result = this.runRule(rule);

                if (result !== true) {
                    this.message = result;
                    this.addErrorClassToContainer();
                    this.displayErrorMessage();
                    this.startValidatingOnChange(validateField);
                    return false;
                }
            }
        }

        // Field is valid.
        this.removeErrorClassFromContainer();
        this.removeErrorMessage();
        return true;
    }; // Field class


    /**
     * For testing purposes.
     */
    function turnOffHtmlValidationAndLengthChecks() {

        $form.attr('novalidate', 'novalidate');

        $.each(fields, function (key, field) {
            field.$el.removeAttr('minlength');
            field.$el.removeAttr('maxlength');
        });
    }

    function validateField(field) {
        if (field.validate()) {
            delete errors[field.name];
        } else {
            errors[field.name] = field;
        }
    }

    function focusFirstInvalidInput() {
        $('.invalid input').filter(":first").focus();
    }

    function clearErrors() {
        errors = {};
        $errorList.empty();
    }

    function validateForm() {

        clearErrors();

        // Validate fields.
        $.each(fields, function (key, field) {
            validateField(field);
        });

        // Check status.
        if (!$.isEmptyObject(errors)) {
            // Form has errors.
            focusFirstInvalidInput();
            return false;
        }

        return true; // form is valid.
    }

    function init(opts) {

        // Cache the form and error list elements.
        $form = $('#' + opts.formId);
        $errorList = $('#' + opts.errorListId);

        // Create fields.
        $.each(opts.fields, function (key, fieldOpts) {
            fields.push(new Field(fieldOpts, opts.containerSelector));
        });

        // Optionally disable HTML validation for testing.
        if (opts.disableHtmlValidation) {
            turnOffHtmlValidationAndLengthChecks();
        }

        // Validate on submit.
        $form.on('submit', validateForm);
    }

    // Public interface.
    return {
        init: init,
        validateForm: validateForm
    }

})();