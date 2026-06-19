// Handle the form submission
document.getElementById('resetPasswordForm').addEventListener('submit', function (event) {
    event.preventDefault();
    var email = document.getElementById('resetEmail').value;

    // Here you can add your AJAX call to send the OTP to the user's email
    // For now, let's just display an alert
    alert('An OTP has been sent to ' + email);

    // Close the popup after submission
    document.getElementById('passwordResetPopup').classList.remove('active');
});

document.getElementById('openpopup').addEventListener("click", function(){
    document.getElementById('passwordResetPopup').classList.add('active');
});

document.querySelector(".popup .close").addEventListener("click", function(){
    document.getElementById('passwordResetPopup').classList.remove('active');
});