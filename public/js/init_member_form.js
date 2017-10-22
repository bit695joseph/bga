(function () {

    var $form = $('#member-form');

    // configure the form validator.
    var opts = {
        formId: 'member-form',
        errorListId : 'error-list',
        containerSelector : '.validation-box',
        disableHtmlValidation: true, // for testing
        fields: {
            firstName: {
                id: 'first-name',
                rules: {
                    'required': true,
                    'minlength': 1,
                    'maxlength': 32
                }
            },
            lastName: {
                id: 'last-name',
                rules: {
                    'required': true,
                    'minlength': 1,
                    'maxlength': 32
                }
            },
            email: {
                id: 'email',
                rules: {
                    'required': true,
                    'minlength': 6,
                    'maxlength': 64,
                    'pattern': /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i
                }
            },
            phone: {
                id: 'phone',
                rules: {
                    'required': true,
                    'minlength': 6,
                    'maxlength': 20,
                    'pattern': /(\d|\s|\(|\)|-|\+)+/,
                    'custom' : {
                        validate : function(value) {
                            // Ensure phone number contains a reasonable
                            // number of digits.
                            var digitCount = value.replace(/[^0-9]/g, "").length;

                            return digitCount >= 4 && digitCount <= 15;
                        },
                        message : 'must contain 4-15 digits'
                    }
                }
            }
        }

    };

    $(function () {
        BgaFormValidator.init(opts);
    });

})();

