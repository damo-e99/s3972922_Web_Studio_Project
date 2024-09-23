const form = document.getElementById("payment_form");
    
form.addEventListener('submit', function(event) {
    event.preventDefault();

    checkForm();
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

    function checkForm() {
        var fnameValue = document.getElementById("firstName").value.trim();
        var lnameValue = document.getElementById("lastName").value.trim();
        var streetValue = document.getElementById("streetName").value.trim();
        var cityValue = document.getElementById("cityName").value.trim();
        var stateValue = document.getElementById("stateName").value.trim();
        var zipValue = document.getElementById("zipCode").value.trim();
            
        var nameCardValue = document.getElementById("cardName").value.trim();
        var numCardValue = document.getElementById("cardNum").value.trim(); 
        var expiMonthCardValue = document.getElementById("expMonth").value.trim();
        var expiYearCardValue = document.getElementById("expYear").value.trim();
        var ccvCardValue = document.getElementById("ccvNum").value.trim();

        //f/lname validation  
    if (fnameValue === '') {
        showError(document.getElementById("firstName"), 'First name is required');
    } else if (fnameValue.length < 2) {
        showError(document.getElementById("firstName"), 'Must be at least 2 characters long');
    } else {
        showSuccess(document.getElementById("firstName"));
    }

    if (lnameValue === '') {
        showError(document.getElementById("lastName"), 'Last name is required');
    } else if (lnameValue.length < 2) {
        showError(document.getElementById("lastName"), 'Must be at least 2 characters long');
    } else {
        showSuccess(document.getElementById("lastName"));
    }

    // Street validation
    if (streetValue === '') {
        showError(document.getElementById("streetName"), 'Street name is required');
    } else {
        showSuccess(document.getElementById("streetName"));
    }

    // City validation
    if (cityValue === '') {
        showError(document.getElementById("cityName"), 'City is required');
    } else {
        showSuccess(document.getElementById("cityName"));
    }

    // State validation
    if (stateValue === '') {
        showError(document.getElementById("stateName"), 'State is required');
    } else {
        showSuccess(document.getElementById("stateName"));
    }

    // ZIP code validation
    if (zipValue === '') {
        showError(document.getElementById("zipCode"), 'ZIP code is required');
    } else {
        showSuccess(document.getElementById("zipCode"));
    }

    // Name on Card validation
    if (nameCardValue === '') {
        showError(document.getElementById("cardName"), 'Name on the card is required');
    } else {
        showSuccess(document.getElementById("cardName"));
    }

    // Card Number validation
    if (numCardValue === '') {
        showError(document.getElementById("cardNum"), 'Card number is required');
    } else {
        showSuccess(document.getElementById("cardNum"));
    }

    // Expiration Month and Year validation
    if (expiMonthCardValue === '0' || expiYearCardValue === '0') {
        showError(document.getElementById("expMonth"), 'Please select a valid expiration date');
        showError(document.getElementById("expYear"), 'Please select a valid expiration date');
    } else {
        showSuccess(document.getElementById("expMonth"));
        showSuccess(document.getElementById("expYear"));
    }

    // CCV validation
    if (ccvCardValue === '') {
        showError(document.getElementById("ccvNum"), 'CCV number is required');
    } else if (ccvCardValue.length !== 3) {
        showError(document.getElementById("ccvNum"), 'CCV number must be 3 digits');
    } else {
        showSuccess(document.getElementById("ccvNum"));
    }

    //Checks to see if the form should submit to the complete php page
    if (
        fnameValue !== '' &&
        lnameValue !== '' &&
        streetValue !== '' &&
        cityValue !== '' &&
        stateValue !== '' &&
        zipValue !== '' &&
        nameCardValue !== '' &&
        numCardValue !== '' &&
        expiMonthCardValue !== '0' &&
        expiYearCardValue !== '0' &&
        ccvCardValue !== '' &&
        ccvCardValue.length === 3
    ) {
        // If all fields are correct, redirect to the complete.php page
        window.location.href = 'complete.php';
    }
}

