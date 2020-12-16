/**
 * ADMIN_LOGIN
 * Revealing module for TOP UP functionalities.
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
let USER_TOPUP = (() => {

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
        // Pressed enter key event.
        $(document).keypress((event) => {
            if ((event.keyCode ? event.keyCode : event.which) === 13) {
                event.preventDefault();
                $('#user_topup').submit();
            }
        });

        // Form submission event.
        $(document).on('submit', '#user_topup', (oEvent) => {
            oEvent.preventDefault();

            // Check first if inputs are valid using the validateInputs() function.
            if (validateInputs().bResult === true) {
                const oData = {
                    amount: $('#amount').val()
                };

                // Perform AJAX request.
                const oResponse = executeRequest(oData);

                // If data sent back by the request is true.
                if (oResponse.bResult === true) {
                    // Redirect to dashboard 
                    $(location).attr('href', oResponse.sUrl)
                } else {
                    // Else, display error message.
                    $('#errorAmount').html("<span class='text-danger'>" + oResponse.sMsg + "</span>");

                    // Remove the error message after 2000 milliseconds.
                    setTimeout(() => {
                        $('#errorAmount').html('');
                    }, 2000);
                }
            }
            else { // This means that there's an error while validating inputs.
                // Display error message.
                $('#errorAmount').html("<span class='text-danger'>" + validateInputs().sMsg + "</span>");

                // Remove the error message after 2000 milliseconds.
                setTimeout(() => {
                    $('#errorAmount').html('');
                }, 2000);
            }
        });
    }

    function executeRequest(oData) {
        let oResponse = {};

        $.ajax({
            url: '/user/top_up_request',    // This is where the request will go.
            type: 'post',                   // POST is for sending data to server.
            data: oData,                    // These are the data to be sent on the URL.
            cache: false,                   // Prevent caching the entered values. Can be removed.
            async: false,                   // Turn off asynchronous mode.
            dataType: 'json',               // JSON since we need to receive the response back.
            success: (data) => {
                // oResponse = data;
                oResponse = data
                window.location.href = "/user/user_topup";
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
        if ($.trim($('#amount').val()).length == null) {
            // Return an object that contains the result and the error message.
            return {
                bResult: false,
                sMsg: 'Please input an amount!'
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
    USER_TOPUP.init();
});