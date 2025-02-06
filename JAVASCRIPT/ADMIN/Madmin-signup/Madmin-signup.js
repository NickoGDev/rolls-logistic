// AVOID FORM RESUBMISSION
document.addEventListener('DOMContentLoaded', function() {
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
  }
})

let firstNameField = document.getElementById('first-name-errorField');
let lastNameField = document.getElementById('last-name-errorField');
let mobileField = document.getElementById('mobile-errorField')
let cityField = document.getElementById('city-errorField');

    function replaceNumericalWithEmpty(event) {
        let currentValue = event.target.value;
        let newValue = currentValue.replace(/[0-9]/g, '');
        
        event.target.value = newValue;
    }
    
    function replaceAlphabet(event) {
        let currentValue = event.target.value;
        let newValue = currentValue.replace(/[a-z A-Z]/g, '');
        event.target.value = newValue;
    }

    function replaceSpecialCharac(event) {
        let currentValue = event.target.value;
        let newValue = currentValue.replace(/[!@#$%^&*()_+={}\[\]:;"'<>,.?/\\|~-]/g, '');
        event.target.value = newValue;  
    }
    
    // Remove particular characters
    firstNameField.addEventListener('input', replaceNumericalWithEmpty);
    firstNameField.addEventListener('input', replaceSpecialCharac);

    lastNameField.addEventListener('input', replaceNumericalWithEmpty);
    lastNameField.addEventListener('input', replaceSpecialCharac);

    cityField.addEventListener('input', replaceNumericalWithEmpty);
    cityField.addEventListener('input', replaceSpecialCharac);

    mobileField.addEventListener('input', replaceAlphabet);
    mobileField.addEventListener('input', replaceSpecialCharac);


// Submit button    
let submitButton = document.getElementById('submit-button');
submitButton.addEventListener('click', function(event) {

    let signupCon = document.querySelector('.signup-inputs-con');
    // Input field
    let firstNameField = document.getElementById('first-name-errorField');
    let lastNameField = document.getElementById('last-name-errorField');
    let passwordField = document.getElementById('password-errorField');
    let mobileField = document.getElementById('mobile-errorField');
    let emailField = document.getElementById('email-errorField');
    let countryField = document.getElementById('country-errorField');
    let cityField = document.getElementById('city-errorField');
    let referalField = document.getElementById('referal-code-errorField');

    // Error prompts
    let firstNamePrompt = document.getElementById('first-name-errorPrompt'); 
    let lastNamePrompt = document.getElementById('last-name-errorPrompt'); 
    let passwordPrompt = document.getElementById('password-errorPrompt'); 
    let mobilePrompt = document.getElementById('mobile-errorPrompt'); 
    let emailPrompt = document.getElementById('email-errorPrompt'); 
    let countryPrompt = document.getElementById('country-errorPrompt');
    let cityPrompt = document.getElementById('city-errorPrompt');


    // PATTERNS
    let passwordPattern = /^(?=.*[!@#$%^&~`*(),.?":{}|<>])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    // PASSWORD REQUIREMENTS
    const passwordRequirements = `Password must contain at least one
    special character,
    one digit,
    one lowercase letter,
    one uppercase letter,
    be at least 8 characters long.`;
    let emailPattern = /[@]/g;

    // CONSTRAINT RULES FOR INPUTS
    let signupConstrainRules = (input, errorPrompt, textDisplay) => {
        // empty value
        if(input.value.trim() === "") {
            checkEmpty(input, errorPrompt, textDisplay);
        }
        //  else if(!emailField.test(emailPattern)) {
        //     errorStyles(input, errorPrompt, "Email must contain @.");
        // } 

        else {
            removeErrorStyles(input, errorPrompt)
        }
    }

    function checkEmpty(input, errorPrompt, textDisplay) {
        errorStyles(input, errorPrompt, textDisplay);
    }

    function checkPassword(input, errorPrompt) {
        if(input.value.trim() === "") {
            errorStyles(input, errorPrompt, 'Password must not be empty.');
        }
        else if (!passwordPattern.test(input.value)) {
            errorStyles(input, errorPrompt, 'Password must contain at least one special character, one digit, one lowercase letter, one uppercase letter, and be at least 8 characters long.');
        } else {
            removeErrorStyles(input, errorPrompt)
        }
    }

    function checkEmail(input, errorPrompt) {
        if(input.value.trim() === "") {
            errorStyles(input, errorPrompt, 'Email must not be empty.');
        } 
        else if(!emailPattern.test(emailField.value)) {
            errorStyles(input, errorPrompt, "Email must contain '@'.");
        } else {
            removeErrorStyles(input, errorPrompt)
        }
    }

    function checkMobile(input, errorPrompt) {
        if(input.value.trim() === '') {
            errorStyles(input, errorPrompt, 'Mobile must not be empty');
        } else if (input.value.length <= 10) {
            errorStyles(input, errorPrompt, 'Mobile must contain 11 numbers.');
        } else {
            removeErrorStyles(input, errorPrompt)
        }
    }

    // Constraint rule for select
    let constraintSelect = (input, errorPrompt, textDisplay) => {
        // Unselected option
        if(input.selectedIndex < 1) {
            errorStyles(input, errorPrompt, textDisplay);
        } else {
            removeErrorStyles(input, errorPrompt)
        }
    }

    function errorStyles(inputField, errorPrompt, textDisplay) {
        event.preventDefault()
            inputField.classList.add('active');
            errorPrompt.textContent = textDisplay
            event.preventDefault()
            signupCon.style.rowGap = "8px";
    }
    function removeErrorStyles(inputField, errorPrompt) {
            inputField.classList.remove('active');
            errorPrompt.textContent = "";
    }

    

    // Check if the input were empty
    signupConstrainRules(firstNameField, firstNamePrompt, "First name must not be empty.");    
    signupConstrainRules(lastNameField, lastNamePrompt, "Last name must not be empty.");


    signupConstrainRules(cityField, cityPrompt, 'City must not be empty');

    checkPassword(passwordField, passwordPrompt);
    checkMobile(mobileField, mobilePrompt);
    checkEmail(emailField, emailPrompt);

    constraintSelect(countryField, countryPrompt, 'Country must not be empty');
    // checkEmpty(referalField, referalPrompt, "Referal must not be empty.");z


})


    // INVALIDATION PROMPT

    let invalidationPrompt = document.getElementById('invalidation-prompt');
    let invalidationTrigger = invalidationPrompt.getAttribute('invalid-trigger');

    let closeInvalidationBtn = document.getElementById('close-invalidation');

    invalidationPromptChanges(invalidationPrompt, invalidationTrigger, closeInvalidationBtn);

function invalidationPromptChanges(invalidationPrompt, invalidationTrigger, closeInvalidationBtn) {
    let invalidationGuideT = document.getElementById('invalidation-guideT');
    let invalidationGuideS = document.getElementById('invalidation-guideS');

    let adminEmail = document.getElementById('admin-email');
    let adminPostEmail = adminEmail.getAttribute('display-email')

    let clickLogin = document.getElementById('link-to-login');

    let authorizationImg = document.getElementById('authorization-img');

    function printedGuides(text, textDisplay) {
        textDisplay.textContent = text;
    }

    let bodyContainer = document.querySelector('.body-container');

    if(invalidationTrigger == "unauthorized") {
        // Reveal invalidation prompt
        invalidationPrompt.classList.add('unauthorized')

        printedGuides('Unauthorized Access!', invalidationGuideT)
        printedGuides(adminPostEmail, adminEmail)
        printedGuides('Main admin is already exist. Please contact below email for inquiries', invalidationGuideS)

        bodyContainer.style.margin = "100px 0px";
        console.log(bodyContainer);
        
        // Remove login link
        clickLogin.style.display = "none";
        // Img
        authorizationImg.src = "../../../IMAGES/GENERAL/unauthorized-personal.jpg";
        closeInvalidationBtn.addEventListener('click', function() {
            invalidationPrompt.classList.remove('unauthorized');
            bodyContainer.style.margin = "0px";
        })
    }   
    else if (invalidationTrigger == 'authorized') {
        // Reveal valid prompt
        invalidationPrompt.classList.add('authorized')

        bodyContainer.style.margin = "0";
        printedGuides('SETUP COMPLETED!', invalidationGuideT);
        printedGuides('TAHOOOT, You can start your shipping business now!', invalidationGuideS)

        // Img
        authorizationImg.src = "../../../IMAGES/GENERAL/authorized-personel.jpg";
        closeInvalidationBtn.style.display = "none";
    }
}

// SHOW PASSWORD BUTTON TOGGLE
let peekPasswordBtn = document.getElementById('peek-password-btn');
let peekImg = document.getElementById('peek');
let passwordField = document.getElementById('password-errorField');


    peekPasswordBtn.addEventListener('click', function() {
        if(passwordField.type === "password") {
            passwordField.type = "text";
            peekImg.src = "../../../IMAGES/USER/SIGNUP/peek-password.png"
        } else {
            passwordField.type = "password";
            peekImg.src = "../../../IMAGES/USER/SIGNUP/close-eye.png"
        }
    })
