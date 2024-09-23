function checkForm() {
    var fullNameOfUser = document.getElementById('fullname');
    var emailOfUser = document.getElementById('email');
    var messageByUser = document.getElementById('message');
    var isValid = true;

    var form = document.querySelector('#contact_form');

    var nameValidation = /^[a-zA-Z]+$/;
    var emailValidation = /^[^\s@]+@[^\s@]+(\.[a-zA-Z]{2,})$/;

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Preventing the form from submitting by default

        if (!validateContacts()) {
            return false;
        }

        form.submit(); // Submiting the form if validation succeeds
    });

    function showError(input, message) {
        var errorElement = document.getElementById(input.id + 'Error');
        errorElement.innerText = message;
        errorElement.style.display = 'block';
    }

    function showSuccess(input) {
        var errorElement = document.getElementById(input.id + 'Error');
        errorElement.style.display = 'none';
    }

    function validateContacts() {
        var fullnameValue = fullNameOfUser.value.trim();
        var emailValue = emailOfUser.value.trim();
        var messageValue = messageByUser.value.trim();

        if (!fullnameValue.match(nameValidation) || fullnameValue.length < 3) {
            showError(fullNameOfUser, 'Please enter a valid name with more than 2 characters using only letters');
            isValid = false;
        } else {
            showSuccess(fullNameOfUser);
        }

        if (!emailValue.match(emailValidation)) {
            showError(emailOfUser, 'Please enter a valid email address in the format "example@example.com"');
            isValid = false;
        } else {
            showSuccess(emailOfUser);
        }

        if (messageValue.length === 0) {
            showError(messageByUser, 'Please enter a message');
            isValid = false;
        } else {
            showSuccess(messageByUser);
        }

        return isValid;
    }
}
