window.onload = () => {
    const button = document.querySelector('#button')
    button.addEventListener('click', calculateBmi)

}

function calculateBmi() {
    const heightofuser = document.querySelector('#height').value;
    const weightofuser = document.querySelector('#weight').value;
    const result = document.querySelector('#result');

    if (!heightofuser || isNaN(heightofuser) || heightofuser < 0) {
        result.innertext = "Please provide a valid height";
        return;
    }else if (!weightofuser || isNaN(weightofuser) || weightofuser < 0) {
        result.innertext  = "Please provide a valid weight";
        return;
    }

    const bmi = (weightofuser / ((heightofuser * heightofuser)  / 10000)).toFixed(2);

    if (bmi < 18.5) {
        result.innerText = `sUnder weight: ${bmi}`;
    } else if (bmi >= 18.5 && bmi < 24.9) {
        result.innerText = `Normal: ${bmi}`;
    } else if (bmi >= 25 && bmi < 29.9) {
    result.innerText = `Over Weight: ${bmi}`;    
    } else if (bmi >= 30 && bmi < 34.9) {
        result.innerText = `Obesity (Classification 1): ${bmi}`;    
    } else if (bmi >= 35.5 && bmi < 39.9) {
        result.innerText = `Obesity (Classification 2): ${bmi}`;    
    } else{
        result.innerText = `Extreme Obesity: ${bmi}`;    
    }
}