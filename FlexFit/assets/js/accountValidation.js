var fname = document.getElementById("fname");
var lname = document.getElementById("lname");
var email = document.getElementById("email");
var pass = document.getElementById("password");
var conf_pass = document.getElementById("confirm_pass");
var phone = document.getElementById("phnumber");

var form = document.querySelector("#form");

//REGULAR EXPRESSION
//email validate
const emailValidate = email => {
    var expressionEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    return expressionEmail.test(String(email).toLowerCase());
}

//phone number validate
//sourced: https://ihateregex.io/expr/phone/ 
var expressionPhone =  /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;


//event listener to prevent form from submitting until formValidate is true
form.addEventListener('submit', function(event) {
    event.preventDefault();

    //prevent form, then call function to validate client-side inputs
    formValidate();
});


//DISPLAY ERROR for border if input field is invalid or valid ------------------------------------------------------------------------
const showError = (input, message) => {
    const formField = input.parentElement;

    formField.classList.remove('success');
    formField.classList.add('error');

    //show error message
    const error = formField.querySelector('small');
    error.textContent = message;
}

const showSuccess = (input) => {
    //get form-fields element
    const formField = input.parentElement;

    formField.classList.remove('error');
    formField.classList.add('success');

    //hide error message, which is why textContent for small element will be empty
    const success = formField.querySelector('small');
    success.textContent = '';
}


//called to check if each input from user is valid
function formValidate() {
    const fnameValue = fname.value.trim();
    const lnameValue = lname.value.trim();
    const emailValue = email.value.trim();
    const passValue = pass.value.trim();
    const conPassValue = conf_pass.value.trim();
    const phoneValue = phone.value.trim();
    
    //f/lname validation  
    if (fnameValue === '') {
        showError(fname, 'First name is required');
    }
    else if (fnameValue.length < 2) {
        showError(fname, 'Must be atleast 2 characters long');
    }
    else {
        showSuccess(fname);
    }

    if (lnameValue === '') {
        showError(lname, 'Last name is required');
    }
    else if (lnameValue.length < 2) {
        showError(lname, 'Must be atleast 2 characters long');
    }
    else {
        showSuccess(lname);
    }

    //email validation
    if (emailValue === '') {
        showError(email, 'Email is required');
    }
    else if (!emailValidate(emailValue)) {
        showError(email, 'Must be a valid email address');
    }
    else {
        showSuccess(email);
    }

    //password/confirm-password validation
    if (passValue === '') {
        showError(pass, 'Password is required');
    }
    else if (passValue != conPassValue) {
        showError(pass, 'Password does not match')
        showError(conf_pass, 'Password does not match');
    }
    else {
        showSuccess(pass);
    }

    if (phoneValue === '') {
        showSuccess(phone);
    }
    else if (!phoneValue.match(expressionPhone)) {
        showError(phone, 'Provide a valid phone number');
    }
    else {
        showSuccess(phone);
    }


}