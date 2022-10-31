
function validInput(input) {
    if (input.value == '' || input.value == null) {
        return false;
    } else if (input.validity.patternMismatch) {
        return false;
    }


    return true;
}

function addFormListeners(form) {
    // Gets forms
    var forms = document.getElementsByTagName('form');

    // Loops through forms

    for (var i = 0; i < forms.length; i++) {
        var form = forms[i];

        // Gets forms inputs
        var inputs = form.querySelectorAll('input[required], textarea[required]');
        var submitButton = form.querySelector('button[type="submit"]');

        var form_inputs_valid = {};

        function validForm(inputsList) {
            var valid = true;

            for (var i = 0; i < inputsList.length; i++) {
                var input = inputsList[i];

                if (!validInput(input)) {
                    valid = false;
                }
            }

            return valid;
        };
        
        submitButton.disabled = true;
        console.log("Disabled Submit");
        // Loops through inputs

        for (var j = 0; j < inputs.length; j++) {
            var input = inputs[j];

            form_inputs_valid[j] = false;

            if (input.required) {
                input.addEventListener('blur', function() {
                    console.log('blur');
                    if (!validInput(this)) {
                        this.classList.add('invalid-form-input');
                        submitButton.disabled = true;
                        form_inputs_valid[j] = false;
                        console.log(form_inputs_valid);
                    } else {
                        form_inputs_valid[j] = true;
                        console.log(form_inputs_valid);
                    };
                });

                input.addEventListener('focus', function() {
                    console.log('focus');
                    if (this.classList.contains('invalid-form-input')) {
                        this.classList.remove('invalid-form-input');
                    };
                });

                input.addEventListener('input', function() {
                    console.log("Typing");
                    form_inputs_valid[j] = validInput(this);

                    if (validForm(inputs)) {
                        submitButton.disabled = false;
                    } else {
                        submitButton.disabled = true;
                    };
                });
            }
        };
    };
};

document.addEventListener("DOMContentLoaded", function(event) {
    console.log("DOM fully loaded");
    addFormListeners();
});