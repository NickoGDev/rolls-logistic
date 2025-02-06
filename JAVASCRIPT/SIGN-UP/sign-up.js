
// AVOID FORM RESUBMISSION
document.addEventListener('DOMContentLoaded', function() {
  if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
  }
});

let signupBtn = document.getElementById("signup-button");

document.addEventListener("DOMContentLoaded", function () {
  signupBtn.addEventListener("click", function () {

    let signupForm = document.getElementById("signup-form");
    signupForm.addEventListener("submit", function (event) {

      // Halt login for credential duplication and invalidation

      // flag for preventDefault
      let hasErrors = false;
      // Input fields and error prompts
      let firstname = document.getElementById("firstname");
      let lastname = document.getElementById("lastname");
      let address = document.getElementById("address");
      let username = document.getElementById("username");
      // halt username
      let haltUsernameSignUp = username.getAttribute('halt-username-signup')
      let password = document.getElementById("password");
      let mobile = document.getElementById('mobile');
      // halt mobile
      let haltMobileSignup = mobile.getAttribute('halt-mobile-signup')
      let email = document.getElementById('email');
      // halt email
      let haltEmailSignup = email.getAttribute('halt-mobile-signup');

      let usernameError = document.getElementById("username-error");
      let firstnameError = document.getElementById("firstname-error");
      let lastnameError = document.getElementById("lastname-error");
      let passwordError = document.getElementById("password-error");
      let addressError = document.getElementById("address-error");
      let mobileError = document.getElementById("mobile-error");
      let emailError = document.getElementById("email-error");

      // Patterns constraints
      let numberPattern = /^\D+$/;
      let passwordPattern = /^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
      let specialCharacterPattern = /[!@#$%^&*(),.?":{}|<>]/;
      let mobilePattern = /\d{11}/;
      let emailPattern = /@/g;


      // Error prompts effects and message
      function errorPrompt(input, errorElement, errorStatement) {
        let styleInput = (input.style.boxShadow = "0 0 4px red");
        styleInput += "; " + (input.style.border = "none");
        let displayMessage = (errorElement.textContent = errorStatement);
        hasErrors = true; // Set flag to indicate errors

        return { styleInput, displayMessage };
      }

      // Remove error prompts effects and message
      function removeErrorPrompt(input, errorElement) {
        let styleInput = (input.style.boxShadow = "0 0 1px rgb(0, 0, 0)");
        styleInput += "; " + (input.style.border = "");

        let displayMessage = (errorElement.textContent = "");

        return { styleInput, displayMessage };
      }
      
   

      if (username.value.trim() === "") {
        errorPrompt(username, usernameError, "Username must not be empty");
      }    
      else if (haltUsernameSignUp == "1") {
        alert('Yo');
        errorPrompt(username, usernameError, "Please use unique username.")
      } 
      else if (username.value.length < 4) {
        errorPrompt(
          username,
          usernameError,
          "Username must contain at least 4 characters."
        );
      } else {
        removeErrorPrompt(username, usernameError);
      }

      if (password.value.trim() === "") {
        errorPrompt(password, passwordError, "Password must not be empty.");
      } else if (!passwordPattern.test(password.value)) {
        errorPrompt(
          password,
          passwordError,
          "Password must contain at least one special character, one digit, one lowercase letter, one uppercase letter, and be at least 8 characters long."
        );
      } else {
        removeErrorPrompt(password, passwordError);
      }

      if (firstname.value.trim() === "") {
        errorPrompt(firstname, firstnameError, "Firstname must not be empty.");
      } else if (!numberPattern.test(firstname.value)) {
        errorPrompt(
          firstname,
          firstnameError,
          "Firstname must not contain numbers."
        );
      } else if (specialCharacterPattern.test(firstname.value)) {
        errorPrompt(
          firstname,
          firstnameError,
          "Firstname must not contain special characters."
        );
      } else {
        removeErrorPrompt(firstname, firstnameError);
      }

      if (lastname.value.trim() === "") {
        errorPrompt(lastname, lastnameError, "Lastname must not be empty.");
      } else if (specialCharacterPattern.test(lastname.value)) {
        errorPrompt(
          lastname,
          lastnameError,
          "Lastname must not contain special characters."
        );
      } else if (!numberPattern.test(lastname.value)) {
        errorPrompt(lastname, lastnameError, "Last must not contain numbers.");
      } else {
        removeErrorPrompt(lastname, lastnameError);
      }

      if (address.value.trim() === "") {
        errorPrompt(address, addressError, "Address must not be empty.");
      } else {
        removeErrorPrompt(address, addressError);
      }

      if(mobile.value.trim() === "") {
        errorPrompt(mobile, mobileError, 'Mobile must not be empty.');
      } 
      else if(haltMobileSignup == "1") {
        errorPrompt(mobile, mobileError, "Please use unique mobile number.")
      } 
      else if (mobile.value.length < 11) {
        errorPrompt(mobile, mobileError, 'Mobile must contain 11 numbers.');
      } 
      else if (mobilePattern.test(mobile)) {
        errorPrompt(mobile, mobileError, 'Mobile must not any characters aside from numbers.');
      } else {
        removeErrorPrompt(mobile, mobileError);
      }

      if (email.value.trim() === "") {
        errorPrompt(email, emailError, 'Email must not be empty.');
      }
      else if (haltEmailSignup == "1") {
        errorPrompt(email, emailError, "Please use unique email.");
      }
      else if (!emailPattern.test(email.value)) {
        errorPrompt(email, emailError, `Email must contain '@'`);
      }  else {
        removeErrorPrompt(email, emailError);
      }

      if (hasErrors) {
        event.preventDefault();
      }
      // else {
             
      // }
    });
  })
});


// Peak password
let peekPassword = document.getElementById("toggle-password");
let password = document.getElementById("password");
let passwordImg = document.getElementById("password-image");

peekPassword.addEventListener("click", function () {
  if (password.type === "password") {
    password.type = "text";
    passwordImg.src = "IMAGES/USER/SIGNUP/close-eye.png";
  } else {
    password.type = "password";
    passwordImg.src = "IMAGES/USER/SIGNUP/peek-password.png";
  }
});


// mobile input
function validateMobileInput(input) {
  input.value = input.value.replace(/\D/g, '');
}

// FORM INVALIDATION CONSTRAINT

// Duplicate username
let validationDuplicateUsername = document.getElementById('validation-duplicate-username');
let validationAttributeUsername = 'Validation-Duplicate-Username';
let closeDuplicateUsername = document.getElementById('close-duplicate-username');

// Duplicate mobile
let validationDuplicateMobile = document.getElementById('validation-duplicate-mobile');
let validationAttributeMobile = 'Validation-Duplicate-Mobile';
let closeDuplicateMobile = document.getElementById('close-duplicate-mobile');

// Duplicate email
let validationDuplicateEmail = document.getElementById('validation-duplicate-email');
let validationAttributeEmail = 'Validation-Duplicate-Email';
let closeDuplicateEmail = document.getElementById('close-duplicate-email');

// Login Success
let loginSuccessPrompt = document.getElementById('validation-success-prompt');
let validationSuccess = "Validation-Success";

// Signup Valid
let signupValid = document.getElementById('signup-valid');
let loginSuccess = "Login-Success";
let closeLoginSucess = document.getElementById('close-login-success');


// PROMPTS FUNCTION
function validationPrompt(validationDuplicate, validationAttribute, closeBtn) {

  if (validationDuplicate.getAttribute(validationAttribute) === "1") {
    validationDuplicate.style.display = "flex";
    closeBtn.addEventListener('click', function () {
      validationDuplicate.style.display = "none";
    });
  }
}

validationPrompt(validationDuplicateUsername, validationAttributeUsername, closeDuplicateUsername);
validationPrompt(validationDuplicateMobile, validationAttributeMobile, closeDuplicateMobile);
validationPrompt(validationDuplicateEmail, validationAttributeEmail, closeDuplicateEmail);
validationPrompt(signupValid, loginSuccess, closeLoginSucess);


  // Account Verified 

  // verified account flags
  let verifiedAccount = document.getElementById('verified-account');
  let verifiedAccountValue = verifiedAccount.value;

  let verifyFirstName = verifiedAccount.getAttribute("verify-firstname");
  let verifyUsername = verifiedAccount.getAttribute('verify-username')
  let verifyEmail = verifiedAccount.getAttribute("verify-email");

  sendMailCredentials(verifiedAccountValue, verifyFirstName, verifyUsername, verifyEmail);  

  function sendMailCredentials(verifiedAccountValue, 
                                verifyFirstname, 
                                verifyUsername, 
                                verifyEmail) {
    if(verifiedAccountValue == "1") {
      sendMail(verifyFirstname, verifyUsername, verifyEmail);
      // alert('Work')
    } 
  }

  function sendMail(firstname, username, email) {

    (function() {
        emailjs.init("VAjfSI3HxAPgNO7W-");
    })();

    var params = {
        to_email: email,
        to_name: firstname,
        username: username
    };

    var serviceId = "service_iy8zun2"; // Email service ID
    var templateId = "template_bgnz00c"; // Email template ID

    emailjs.send(serviceId, templateId, params)
        .then(res => {
            alert("Email Verification Sent Successfully");
        })
        .catch(error => {
            console.error("Error sending email:", error);
            // alert("Error sending email. Please check the recipient address.");
        });
}


