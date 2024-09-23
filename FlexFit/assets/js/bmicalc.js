const button = document.getElementById('button');
const heightInput = document.getElementById('height');
const weightInput = document.getElementById('weight');
const bmiResult = document.getElementById('bmiResult');

button.addEventListener('click', function () {
    const height = parseFloat(heightInput.value);
    const weight = parseFloat(weightInput.value);

    if (!isNaN(height) && !isNaN(weight)) {
        const apiUrl = `https://body-mass-index-bmi-calculator.p.rapidapi.com/metric?weight=${weight}&height=${height}`;

        const xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener('load', function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const bmi = response.bmi;

                bmiResult.textContent = `Result: ${bmi}`;
            } else {
                bmiResult.textContent = 'Failed to calculate BMI';
            }
        });

        xhr.open('GET', apiUrl);
        xhr.setRequestHeader('X-RapidAPI-Key', '79318d1aa5msh323f4bf4db11b7dp140f33jsnb75d37e8336d');
        xhr.setRequestHeader('X-RapidAPI-Host', 'body-mass-index-bmi-calculator.p.rapidapi.com');
        xhr.send();
    } else {
        bmiResult.textContent = 'Please enter valid height and weight';
    }
});
