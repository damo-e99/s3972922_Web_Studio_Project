var newPass = document.getElementById("ResetPassword");
var RetypeNewP = document.getElementById("RetypePassword");
var form = document.getElementsByTagName("form")[0];

form.addEventListener('submit', function(event) {
    
    if (newPass.value !== RetypeNewP.value) {
        event.preventDefault();
        showError(newPass, "Passwords do not match");
    }else {
        form.submit();
    }

});

const showError = (input, message) => {
    const formField = input.parentElement;

    formField.classList.remove('success');
    formField.classList.add('error');

    //show error message
    const error = formField.querySelector('small');
    error.textContent = message;
}