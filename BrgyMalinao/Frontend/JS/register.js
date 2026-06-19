function nextStep(step) {
    document.querySelectorAll('.form-step').forEach(function(stepDiv) {
        stepDiv.style.display = 'none';
    });
    document.getElementById('step' + step).style.display = 'block';

    // Update header
    document.querySelectorAll('.form-header .step').forEach(function(headerStep) {
        headerStep.style.backgroundColor = 'lightgray';
        headerStep.style.color = 'gray';
    });
    document.getElementById('step' + step + '-header').style.backgroundColor = 'green';
    document.getElementById('step' + step + '-header').style.color = 'white';
}

function prevStep(step) {
    nextStep(step);
}