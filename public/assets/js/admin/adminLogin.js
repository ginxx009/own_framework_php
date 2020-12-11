/**
 * ADMIN_LOGIN
 * Revealing module for login functionalities.
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
let ADMIN_LOGIN = (() => {

    /**
     * init
     * Constructor-like method for this module.
     */
    function init() {
        setDomEvents();
    }

    /**
     * setDomEvents
     */
    function setDomEvents() {
        $(document).on('click', '#forgotPasswordBtn', () => {
            toggleForms(true);
        });

        $(document).on('click', '#backToLoginBtn', () => {
            toggleForms(false);
        });

        // Add input text effect on focus event.
        $(document).on('focus', '.input', () => {
            $(this).closest('.input-div').addClass('focus');
        });

        // Add input text effect on focusout event.
        $(document).on('focusout', '.input', () => {
            if ($(this).val() === '') {
                $(this).closest('.input-div').removeClass('focus');
            }
        });

        // Allow only alphanumeric characters and an underscore on username input via RegExp.
        $(document).on('keyup keydown', '#username', (event) => {
            // Input must not start by a number or any special character.
            if (this.value.length === 1 && this.value.match(/[^a-zA-Z]/)) {
                return this.value = this.value.replace(this.value, '');
            }
            return this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
        });

        // Pressed enter key event.
        $(document).keypress((event) => {
            if ((event.keyCode ? event.keyCode : event.which) === 13) {
                event.preventDefault();
                $('#loginForm').submit();
            }
        });

        // Form submission event.
        $(document).on('submit', '#loginForm', (oEvent) => {
            oEvent.preventDefault();

            // Check first if inputs are valid using the validateInputs() function.
            if (validateInputs().bResult === true) {
                const oData = {
                    sUsername: $('#username').val(),
                    sPassword: $('#password').val()
                };

                // Perform AJAX request.
                const oResponse = executeRequest(oData);

                // If data sent back by the request is true.
                if (oResponse.result === true) {
                    // Redirect to dashboard 
                    $(location).attr('href', oResponse.sUrl)
                } else {
                    // Else, display error message.
                    $('#loginError').html("<span class='text-danger'>" + oResponse.sMsg + "</span>");

                    // Remove the error message after 2000 milliseconds.
                    setTimeout(() => {
                        $('#loginError').html('');
                    }, 2000);
                }
            }
            else { // This means that there's an error while validating inputs.
                // Display error message.
                $('#loginError').html("<span class='text-danger'>" + validateInputs().sMsg + "</span>");

                // Remove the error message after 2000 milliseconds.
                setTimeout(() => {
                    $('#loginError').html('');
                }, 2000);
            }
        });

    $(document).on('click', '#resetPassword', () => {
            const oData = { email: $('#email').val() };
            const oResponse = executeRequest(oData);

            $('#resetPasswordError').html("<span class='text-danger'>" + oResponse.msg + "</span>");

            // Remove the error message after 2000 milliseconds.
            setTimeout(() => {
                $('#resetPasswordError').html('');
            }, 2000);
        });
    }

    function executeRequest(oData) {
        let oResponse = {};

        $.ajax({
            url: '/admin/doLogin',  // This is where the request will go.
            type: 'post',           // POST is for sending data to server.
            data: oData,            // These are the data to be sent on the URL.
            cache: false,           // Prevent caching the entered values. Can be removed.
            async: false,           // Turn off asynchronous mode.
            dataType: 'json',       // JSON since we need to receive the response back.
            success: (data) => {
                oResponse = data;
            }
        });

        return oResponse;
    }

    function toggleForms(bDisplay) {
        $('form[name="forgotPassword"]').css('display', bDisplay === true ? 'block' : 'none');
        $('form[name="login"]').css('display', bDisplay === true ? 'none' : 'block');
    }

    /**
     * validateInputs
     * Validates the inputs of the user before submission.
     */
    function validateInputs() {
        // Check username input min length.
        if ($.trim($('#username').val()).length < 4) {
            // Return an object that contains the result and the error message.
            return {
                bResult: false,
                sMsg: 'Username must be minimum of 4 characters.'
            };
        }

        // Check username input max length.
        if ($.trim($('#username').val()).length > 15) {
            // Return an object that contains the result and the error message.
            return {
                bResult: false,
                sMsg: 'Username must be maximum of 15 characters.'
            };
        }

        // Check password input min length.
        if ($.trim($('#password').val()).length === 0) {
            // Return an object that contains the result and the error message.
            return {
                bResult: false,
                sMsg: 'Password cannot be empty.'
            };
        }

        // Return true if no errors on input validations.
        return {
            bResult: true
        };
    }

    return { init }
})();

$(() => {
    ADMIN_LOGIN.init();
});