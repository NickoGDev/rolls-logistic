// AVOID FORM RESUBMISSION
document.addEventListener('DOMContentLoaded', function() {
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
})

// Prevent user from going back to previous page
history.pushState(null, null, document.URL);
window.addEventListener('popstate', function () {
    history.pushState(null, null, document.URL);
});

let submitForm = document.getElementById('submit-form');

submitForm.addEventListener('click', function() {
    let loginForm = document.getElementById('login-form');


    loginForm.addEventListener('submit', function(event) {
    // input fields
    let username = document.getElementById('username');
    let password = document.getElementById('password');

    // error constraints 
    let usernameError = document.getElementById('username-error');
    let passwordError = document.getElementById('password-error');

    // field form
    let fieldForm = document.getElementById('field-form');
    let hasError = false;

    if(username.value.trim() === '') {
        usernameError.textContent = "Username must not be empty.";
        username.style.outline = 'none';
        username.style.boxShadow = "0 0 4px red";
        fieldForm.style.rowGap = "8px";
        hasError = true;
    } else {
        usernameError.textContent = "";
        username.style.outline = '';
        username.style.boxShadow = "";
        fieldForm.style.rowGap = "15px";
    }
    if(password.value.trim() === '') {
        passwordError.textContent = "Password must not be empty.";
        password.style.outline = 'none';
        password.style.boxShadow = "0 0 4px red";
        hasError = true;
    }  else {
        passwordError.textContent = "";
        password.style.outline = '';
        password.style.boxShadow = "";
        fieldForm.style.rowGap = "15px";
    }
    if (hasError) {
        event.preventDefault();
    }
    });
})


let peekPassword = document.getElementById('peek-password');
let imageDisplay = document.getElementById('imageDisplay');
let password = document.getElementById('password');

peekPassword.addEventListener('click', function() {

    if (password.type === "password") {
        imageDisplay.src = "IMAGES/USER/LOGIN/close-eye.png";
        password.type = "text";
    } else {
        imageDisplay.src = "IMAGES/USER/LOGIN/peek-password.png";
        password.type = "password";
    }
})


// PROMPTS FUNCTION
let validationInvalidCredential = document.getElementById('validation-invalid-credential')
let invalidCredentialAttribute = 'Validation-Invalid-Credential'; 
let invalidCredentialBtn = document.getElementById('invalid-btn')

function validationPrompt(validationDuplicate, validationAttribute, closeBtn) {

    if (validationDuplicate.getAttribute(validationAttribute) === "1") {
      validationDuplicate.style.display = "flex";
      closeBtn.addEventListener('click', function () {
        validationDuplicate.style.display = "none";
      });
    }
  }
  
  validationPrompt(validationInvalidCredential, invalidCredentialAttribute, invalidCredentialBtn);
  