document.addEventListener('DOMContentLoaded', () => {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');
    const passwordMismatch = document.getElementById('passwordMismatch');
  
    signUpButton.addEventListener('click', () => {
      container.classList.add("right-panel-active");
    });
  
    signInButton.addEventListener('click', () => {
      container.classList.remove("right-panel-active");
    });
  
    togglePassword.addEventListener('click', () => {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      togglePassword.classList.toggle('fa-eye-slash');
    });
  
    toggleConfirmPassword.addEventListener('click', () => {
      const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPassword.setAttribute('type', type);
      toggleConfirmPassword.classList.toggle('fa-eye-slash');
    });
  
    confirmPassword.addEventListener('input', () => {
      if (password.value !== confirmPassword.value) {
        passwordMismatch.style.display = 'block';
      } else {
        passwordMismatch.style.display = 'none';
      }
    });
  
    password.addEventListener('input', () => {
      const errorMessage = validatePassword(password.value, email.value, firstname.value, lastname.value);
      if (errorMessage) {
        passwordMismatch.innerHTML = errorMessage;
        passwordMismatch.style.display = 'block';
      } else {
        passwordMismatch.style.display = 'none';
      }
    });
  
    document.querySelector('form[method="post"]').addEventListener('submit', function(event) {
      const firstname = document.getElementById('Firstname').value;
      const lastname = document.getElementById('Lastname').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const errorMessage = validatePassword(password, email, firstname, lastname);
  
      if (errorMessage) {
        event.preventDefault(); // Prevent form submission
        alert(errorMessage); // Display error message
      }
    });
  
    function validatePassword(password, email, firstname, lastname) {
      const minLength = 8;
      const upperCase = /[A-Z]/;
      const lowerCase = /[a-z]/;
      const digit = /\d/;
      const specialChar = /[!@#$%^&*_]/;
      const personalInfo = new RegExp(firstname, 'i') || new RegExp(lastname, 'i') || new RegExp(email.split('@')[0], 'i');
  
      if (password.length < minLength) {
        return 'Password must be at least 8 characters long.';
      }
      if (!upperCase.test(password)) {
        return 'Password must contain at least one uppercase letter.';
      }
      if (!lowerCase.test(password)) {
        return 'Password must contain at least one lowercase letter.';
      }
      if (!digit.test(password)) {
        return 'Password must contain at least one digit.';
      }
      if (!specialChar.test(password)) {
        return 'Password must contain at least one special character.';
      }
      if (personalInfo.test(password)) {
        return 'Password should not contain easily obtainable personal information.';
      }
      return '';
    }
  
    function clearErrorMessages() {
      document.getElementById('passwordIncorrect').style.display = 'none';
      document.getElementById('emailAlreadyUsed').style.display = 'none';
      document.getElementById('passwordMismatch').style.display = 'none';
  
      document.getElementById('Firstname').value = '';
      document.getElementById('Lastname').value = '';
      document.getElementById('email').value = '';
      document.getElementById('password').value = '';
      document.getElementById('confirmPassword').value = '';
    }
  
    signInButton.addEventListener('click', clearErrorMessages);
    signUpButton.addEventListener('click', clearErrorMessages);
  
    if (performance.navigation.type === 1) {
      clearErrorMessages();
    }
  });
  