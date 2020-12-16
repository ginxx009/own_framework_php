/**
 * ADMIN_REGISTER
 * Revealing module for register functionalities.
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
let ADMIN_REGISTER = (() => {

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
    function setDomEvents() 
    {
        // Pressed enter key event.
        $(document).keypress((event) => {
            if ((event.keyCode ? event.keyCode : event.which) === 13) {
                event.preventDefault();
                $('#formRegister').submit();
            }
        });

        // Form submission event.
        $(document).on('submit', '#formRegister', (oEvent) => {
            oEvent.preventDefault();

            // Check first if inputs are valid using the validateInputs() function.
            if (validateInputs().bResult === true) {
                const oData = {
                    fullname: $('#fullname').val(),
                    username: $('#username').val(),
                    password: $('#password').val(),
                    retypePassword: $('#retypePassword').val()
                };

                // Perform AJAX request.
                const oResponse = executeRequest(oData);

                // If data sent back by the request is true.
                if (oResponse.bResult === true) {
                    // Redirect to dashboard 
                    alert(oResponse.sMsg);
                    $(location).attr('href', "/login")
                } else {
                    // Else, display error message.
                    $('#registerError').html("<span class='text-danger'>" + oResponse.sMsg + "</span>");

                    // Remove the error message after 2000 milliseconds.
                    setTimeout(() => {
                        $('#registerError').html('');
                    }, 2000);
                }
            }
            else { // This means that there's an error while validating inputs.
                // Display error message.
                $('#registerError').html("<span class='text-danger'>" + validateInputs().sMsg + "</span>");

                // Remove the error message after 2000 milliseconds.
                setTimeout(() => {
                    $('#registerError').html('');
                }, 2000);
            }
        });
    }

    function executeRequest(oData) {
        let oResponse = {};

        $.ajax({
            url: '/register/doRegister',  // This is where the request will go.
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

        // Check password input min length.
        if ($.trim($('#fullname').val()).length === 0) {
            // Return an object that contains the result and the error message.
            return {
                bResult: false,
                sMsg: 'Fullname cannot be empty.'
            };
        }

        // Check password input min length.
        if ($.trim($('#retypePassword').val()) != $.trim($('#password').val())) {
            // Return an object that contains the result and the error message.
            return {
                bResult: false,
                sMsg: 'Password Does not Match.'
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
    ADMIN_REGISTER.init();
});