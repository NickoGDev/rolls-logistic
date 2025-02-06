// MODULES
import DomUtils from '../../../JQUERY-MODULES/DomUtils.js';

$(document).ready(function() { 
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // INSTANCE OF A CLASS THAT HANDLES ADDING AND REMOVING STYLES.
    let domUtils = new DomUtils();

    // Submission button
    let submitBtn = $('#submit');

    submitBtn.click(function(event) {
        event.preventDefault();
        submitForm();
    });

    let firstName = $('#first-name');
    let lastName = $('#last-name');
    let middleInitial = $('#middle-initial')
    let email = $('#email');
    let password = $('#password');
    let country = $('#country');
    let city = $('#city');
    let address = $('#address');  
    let phoneNumber = $('#phone-number');
    let age = $('#age');
    let sex = $('#sex');

    // Clear inputs

    function clearInputValues() {
        firstName.val('');
        lastName.val('');
        middleInitial.val('');
        email.val('');
        password.val('');
        country.val('');
        city.val('');
        address.val('');
        phoneNumber.val('');
        age.val('');
        sex.val('');
          // Return true if all fields are empty
    }

    // Error prompts
    let firstNameError = $('#first-name-error');
    let lastNameError = $('#last-name-error');
    let emailError = $('#email-error');
    let passwordError = $('#password-error');
    let countryError = $('#country-error');
    let cityError = $('#city-error');
    let addressError = $('#address-error');
    let phoneError = $('#phone-error');
    let ageError = $('#age-error');
    let sexError = $('#sex-error');

    // Border error styles
    let firstNameBorder = $('#border-first-name');
    let lastNameBorder = $('#border-last-name');
    let emailBorder = $('#border-email');
    let passwordBorder = $('#border-password');
    let countryBorder = $('#border-country');
    let cityBorder = $('#border-city');
    let addressBorder = $('#border-address');
    let phoneBorder = $('#border-phone');
    let ageBorder = $('#border-age');
    let sexBorder = $('#border-sex');

    onClickCheckField(firstName, firstNameError, "First name must not be empty", firstNameBorder, 'invalid');
    onClickCheckField(lastName, lastNameError, "Last name must not be empty", lastNameBorder,'invalid');
    onClickCheckField(email, emailError, "Email must not be empty", emailBorder, 'invalid');
    onClickCheckField(password, passwordError, "Password must not be empty", passwordBorder, 'invalid');
    onClickCheckField(country, countryError, "Country must not be empty", countryBorder, 'invalid');
    onClickCheckField(city, cityError, "City must not be empty", cityBorder, 'invalid');
    onClickCheckField(address, addressError, "Address must not be empty", addressBorder, 'invalid');
    onClickCheckField(phoneNumber, phoneError, "Phone number must not be empty", phoneBorder, 'invalid');
    onClickCheckField(age, ageError, "Age must not be empty", ageBorder, 'invalid');
    onClickCheckField(sex, sexError, "Sex must not be empty", sexBorder, 'invalid');

    function onClickCheckField(input, displayError, errorPrompt, stylesEle, classList) {
        input.on('blur', function() {
            checkEmptyInputs(input, displayError, errorPrompt, stylesEle, classList);
        });

        input.on('input', function() {
            if ($.trim(input.val()) !== "") {
                domUtils.removeClass(stylesEle, classList);
            } else {
                domUtils.removeClass(stylesEle, classList);
            }
        });
    }

    function checkEmptyInputs(input, displayError, errorPrompt, stylesEle, classList) {
        if ($.trim(input.val()) === '') {
            domUtils.addText(displayError, errorPrompt);
            domUtils.addClass(stylesEle, classList);
            return false;
        } else {
            domUtils.removeText(displayError);
            domUtils.removeClass(stylesEle, classList);
            return true;
        }
    }
    
    // FUNCTION TO CHECK DUPLICATES DATA, CONSIDER AS PROMISE FUNCTION
    function checkDuplicates(email, phone) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: "Smember-signup.php",
                type: "POST",
                dataType: 'json',
                data: {
                    action: "check_duplicates",
                    email_candidate: email,
                    phone_candidate: phone,
                },
                success: function(response) {
                    let trimEmail = $.trim(response.email);
                    let trimPhone = $.trim(response.phone);
                    console.log(response.email)
                    console.log(response.phone)
    
                        if(trimEmail === "duplicate_email" || trimPhone === "duplicate_phone") {
                            if (trimEmail === "duplicate_email" && trimPhone === "duplicate_phone") {
                                domUtils.addClass(emailBorder, 'invalid');
                                domUtils.addText(emailError, 'Email is already existing.');
            
                                domUtils.addClass(phoneBorder, 'invalid');
                                domUtils.addText(phoneError, 'Phone number is already existing.');
                                // console.log('Duplicate phone and email are not valid')
                            } 
                            if (trimPhone === "duplicate_phone") {
                                domUtils.addClass(phoneBorder, 'invalid');
                                domUtils.addText(phoneError, 'Phone number is already existing.');
                                // console.log('Duplicate phone is not valid')
                            } 
                            if (trimEmail === "duplicate_email") {
                                domUtils.addClass(emailBorder, 'invalid');
                                domUtils.addText(emailError, 'Email is already existing.');
                                // console.log('Duplicate email is not valid')
                            } 
                            console.log('Duplicate email and phone are not valid');
                            resolve(false);
                        } else {
                            resolve(true);
                        }
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            })
        });
    };

    // USABLE PATTERNS
    let numericPatterns = /[0-9]/g; 
    let alphabetPatterns = /[A-Za-z]/g;
    let specialCharacterPatterns = /[!@#$%^&*()_+={}\[\]:;"'<>,.?/\\|~-]/g;

    // FUNCTION TO CHECK AND FILTER OUT TEXT FIELD
    replaceNumericalValWithEmpty(firstName);
    replaceNumericalValWithEmpty(lastName);
    replaceNumericalValWithEmpty(middleInitial);
    replaceNumericalValWithEmpty(city);

    function replaceNumericalValWithEmpty(inputField) {
        inputField.on('input', function() {
            let currentValue = $(this).val();
            let newValue = currentValue.replace(numericPatterns, '')
            $(this).val(newValue);
        });
    };

    // FUNCTION TO CHECK ALPHABET
    replaceAlphabetWithEmpty(phoneNumber, alphabetPatterns);
    replaceAlphabetWithEmpty(age, alphabetPatterns);

    function replaceAlphabetWithEmpty(inputField, alphabetPatterns) {
        inputField.on('input', function() {
            let currentValue = $(this).val();
            let newValue = currentValue.replace(alphabetPatterns, '');
            $(this).val(newValue);
        });
    };

    // FUNCTION TO CHECK SPECIAL CHARACTERS
    replaceSpecialCharactersWithEmpty(firstName);
    replaceSpecialCharactersWithEmpty(lastName);
    replaceSpecialCharactersWithEmpty(middleInitial);
    replaceSpecialCharactersWithEmpty(city);
    replaceSpecialCharactersWithEmpty(phoneNumber);
    replaceSpecialCharactersWithEmpty(age);

    function replaceSpecialCharactersWithEmpty(inputField) {
        inputField.on('input', function() {
            let currentValue = $(this).val();
            let newValue = currentValue.replace(specialCharacterPatterns, '');
            $(this).val(newValue);
        })
    }

    let passwordConstraintCon = $('#constraint-password-con');

    // FUNCTION TO CHECK CONSTRAINTS PASSWORD
    let passwordUpperCaseRequirement = /[A-Z]/;
    let passwordLowerCaseRequirement = /[a-z]/;
    let passwordSpecialCharacRequirement = /[!@#$%^&*()_+={}\[\]:;"'<>,.?\/\\|~-]/;
    let passwordNumericRequirement = /[0-9]/;
    let emailRequirement = /[@]/;

    // INPUT REQUIREMENTS
    let passwordSpecial = $('#password-special');
    let passwordLength = $('#password-length');
    let passwordUpperLower = $('#password-upper-lower');
    let passwordNumeric = $('#password-numeric');


    // IMG VALID REVEAL
    let validImgLength = $('#valid-password-length');
    let validImgSpecial = $('#valid-password-special');
    let validImgUpperLower = $('#valid-password-upper-lower');
    let validImgNumeric = $('#valid-password-numeric')


    // EMAIL REQUIREMENT
    function emailPasswordRequirement(email) {
        if(emailRequirement.test(email)) {
            return true;
        } else {
            domUtils.addClass(emailBorder, 'invalid');
            domUtils.addText(emailError, 'Email must contain "@".');
            return false;
        }
    }


    // PASSWORD METER BAR
    let firstBar = $('#first-bar');
    let secondBar = $('#second-bar');
    let thirdBar = $('#third-bar'); 

    let meterMetricDisplay = $('#meter-display');
    function meterBarStyles(meterCount) {
        // Reset all bars before applying new styles
        domUtils.removeClass(firstBar, 'weak');
        domUtils.removeClass(firstBar, 'mild');
        domUtils.removeClass(firstBar, 'strong');
        domUtils.removeClass(secondBar, 'mild');
        domUtils.removeClass(secondBar, 'strong');
        domUtils.removeClass(thirdBar, 'strong');

        domUtils.removeClass(meterMetricDisplay, 'strong');
        domUtils.removeClass(meterMetricDisplay, 'mild');
        domUtils.removeClass(meterMetricDisplay, 'weak');

        domUtils.addText(meterMetricDisplay, '');
        if(meterCount >= 4) {
            domUtils.addClass(firstBar, 'strong');
            domUtils.addClass(secondBar, 'strong');
            domUtils.addClass(thirdBar, 'strong');
            domUtils.addText(meterMetricDisplay, 'Strong');
            domUtils.addClass(meterMetricDisplay, 'strong');
        } 
        else if(meterCount > 1 && meterCount < 4) {
            domUtils.addClass(firstBar, 'mild');
            domUtils.addClass(secondBar, 'mild');
            domUtils.addText(meterMetricDisplay, 'Mild');
            domUtils.addClass(meterMetricDisplay, 'mild');
        } 
        else if(meterCount === 1 ) {
            domUtils.addClass(firstBar, 'weak');
            domUtils.addText(meterMetricDisplay, 'Weak');
            domUtils.addClass(meterMetricDisplay, 'weak');
        } else {
            
        }
    }

    // FUNCTION FOR PASSWORD VALIDATION STYLES
    function stylesForConstraintPassword(invalidationTxt, txtStyle, 
                                        displayTxt, message, 
                                        imgInvalid, imgStyle, 
                                        validationState
                                       ) {
                                            if(validationState === true) {
                                                domUtils.addClass(invalidationTxt, txtStyle);
                                                domUtils.addText(displayTxt, message);
                                                domUtils.addClass(imgInvalid, imgStyle)
                                            } 
                                            else {
                                                domUtils.removeClass(invalidationTxt, txtStyle);
                                                domUtils.addText(displayTxt, message);
                                                domUtils.removeClass(imgInvalid, imgStyle);
                                            }
    }


    // Disabled the submit if forget to check the checkbox
    let declarationCheckBox =  $('#declaration-checkbox')
    function declarationAgreement() {
        if(!declarationCheckBox.prop('checked')) {
            submitBtn.prop('disabled', true);
            domUtils.addClass(submitBtn, 'halt');
        } else {
            submitBtn.prop('disabled', false);
            domUtils.removeClass(submitBtn, 'halt');
        }
    }
    declarationCheckBox.change(declarationAgreement);
    declarationAgreement();

    // CHECK PASSWORD REQUIREMENTS
    checkConstraintPassword(password)
    function checkConstraintPassword(inputField) {
        inputField.on('input', function() {
            let currentValue = $(this).val();
            let passwordMeterCount = 0;
            if($.trim(currentValue) !== "") { 
                domUtils.addClass(passwordConstraintCon, 'visible');

                if(passwordSpecialCharacRequirement.test(currentValue)) {
                    stylesForConstraintPassword(passwordSpecial, 'valid',
                                                passwordSpecial, 'Contained atleast 1 special character.',
                                                validImgSpecial, 'valid',
                                                true);
                    passwordMeterCount += 1;
                } else {
                    stylesForConstraintPassword(passwordSpecial, 'valid',
                                                passwordSpecial, '* Must contain atleast 1 special character.',
                                                validImgSpecial, 'valid',
                                                false);
                }

                if(currentValue.length > 5) {
                    stylesForConstraintPassword(passwordLength, 'valid',
                                                passwordLength, 'Contained atleast 6 characters.',
                                                validImgLength, 'valid',
                                                true);
                    passwordMeterCount += 1;
                } else {                
                    stylesForConstraintPassword(passwordLength, 'valid',
                                                passwordLength, '* Must Contain atleast 6 characters.',
                                                validImgLength, 'valid',
                                                false);
                }

                if(passwordUpperCaseRequirement.test(currentValue) && passwordLowerCaseRequirement.test(currentValue)) {
                    stylesForConstraintPassword(passwordUpperLower, 'valid',
                                                passwordUpperLower, 'Contained atleast 1 upper and lower case.',
                                                validImgUpperLower, 'valid',
                                                true);
                    passwordMeterCount += 1;

                } else {
                    stylesForConstraintPassword(passwordUpperLower, 'valid',
                                                passwordUpperLower, '* Must contain atleast 1 uppercase and lowercase.',
                                                validImgUpperLower, 'valid',
                                                false);
                }

                if(passwordNumericRequirement.test(currentValue)) {
                    stylesForConstraintPassword(passwordNumeric, 'valid',
                                                passwordNumeric, 'Contained atleast 1 number.',
                                                validImgNumeric, 'valid',
                                                true);
                    passwordMeterCount += 1;

                } else {
                    stylesForConstraintPassword(passwordNumeric, 'valid',
                                                passwordNumeric, '* Must contain atleast 1 number.',
                                                validImgNumeric, 'valid',
                                                false);
                }
                console.log(passwordMeterCount)
                meterBarStyles(passwordMeterCount);
               // PASSWORD VALIDATION CONFIRM FOR DATA SUBMSSSION
                if(passwordSpecialCharacRequirement.test(currentValue) && 
                    currentValue.length > 5 && 
                    passwordUpperCaseRequirement.test(currentValue) && passwordLowerCaseRequirement.test(currentValue) &&
                    passwordNumericRequirement.test(currentValue)) {

                    // DATA IS CLEARED, READY FOR SUBMISSION
                    domUtils.removeClass(passwordBorder, 'invalid')
                    console.log('Submission ready') 
                } else {
                    // DATA IS NOT CLEARED FOR SUBMISSION
                    domUtils.addClass(passwordBorder, 'invalid')
                }   
            } else {
                domUtils.removeClass(passwordConstraintCon, 'visible');
            }
        });
        inputField.click(function() {

        });
    }

    // CLOSE PASSWORD REQUIREMENTS
    let closePasswordRequirement = $('#close-password-requirement');
    closePasswordRequirement.click(function() {
        domUtils.removeClass(passwordConstraintCon, 'visible');
    })

    // 
    function immediatePasswordValidation(password) {
        let currentValue = password.val();
        console.log('Password cleared')
        if(passwordSpecialCharacRequirement.test(currentValue) &&
            currentValue.length > 5 &&
            passwordUpperCaseRequirement.test(currentValue) &&
            passwordLowerCaseRequirement.test(currentValue) &&
            passwordNumericRequirement.test(currentValue)) {
            return true
        } else {
            domUtils.addClass(passwordConstraintCon, 'visible')
            domUtils.addClass(passwordBorder, 'invalid')
            return false;
        }
    }
    
    function submitForm() {
        // Get input values
        let firstNameVal = firstName.val();
        let lastNameVal = lastName.val();
        let middleInitialVal = $('#middle-initial').val();
        let emailVal = email.val();
        let passwordVal = password.val();
        let countryVal = country.val();
        let cityVal = city.val();
        let addressVal = address.val();
        let phoneNumberVal = phoneNumber.val();
        let ageVal = age.val();
        let sexVal = sex.val();
        
        let valid = true;

        // Validate Functions
        valid &= emailPasswordRequirement(emailVal);
        
        valid &= checkEmptyInputs(firstName, firstNameError, 'First name must not be empty.', firstNameBorder, 'invalid');
        valid &= checkEmptyInputs(lastName, lastNameError, 'Last name must not be empty.', lastNameBorder, 'invalid');
        valid &= checkEmptyInputs(email, emailError, 'Email must not be empty.', emailBorder, 'invalid');
        valid &= checkEmptyInputs(password, passwordError, 'Password must not be empty.', passwordBorder, 'invalid');
        valid &= checkEmptyInputs(country, countryError, 'Country must not be empty.', countryBorder, 'invalid');
        valid &= checkEmptyInputs(city, cityError, 'City must not be empty.', cityBorder, 'invalid');
        valid &= checkEmptyInputs(address, addressError, 'Address must not be empty.', addressBorder, 'invalid');
        valid &= checkEmptyInputs(phoneNumber, phoneError, 'Phone number must not be empty.', phoneBorder, 'invalid');
        valid &= checkEmptyInputs(age, ageError, 'Age must not be empty.', ageBorder, 'invalid');
        valid &= checkEmptyInputs(sex, sexError, 'Sex must not be empty.', sexBorder, 'invalid');
        
        valid &= immediatePasswordValidation(password);

        // checkValidInput(valid);
        // PROMISE FUNCTIONS Waits checkDuplicates function to operate before executing below code.
        checkDuplicates(emailVal, phoneNumberVal).then(validationResult => {
            valid &= validationResult;
            console.log(checkDuplicates(emailVal, phoneNumberVal));
            console.log("Submission: ", valid);
            checkValidInput(valid);
        });


        // CHECKING THE STATE OF valid variable
        function checkValidInput(valid) {
            if (!valid) {
                console.log("Submission denied ", valid);
                return;
            } else {
                submitApplicantData();
            }     
        } 

        // PROMISE FUNCTIONS Waits replaceNumericalValWithEmpty function to operate before executing below code.
        
        // Submit the finalize data
        function submitApplicantData() {
            $.ajax({
             url: "Smember-signup.php",
             type: "POST",
             data: {
                 action: "insert_employee",
                 first_name: firstNameVal,
                 last_name: lastNameVal,
                 middle_initial: middleInitialVal,
                 email: emailVal,
                 password: passwordVal,
                 country: countryVal,
                 city: cityVal,
                 address: addressVal,
                 phone_number: phoneNumberVal,
                 age: ageVal,
                 sex: sexVal
             },
             success: function(response) {
                
                 let successPrompt = $('#prompt-success');
                 let closeIconSuccess = $('#close-icon-success');
     
                 if (response.trim() === "signup_success") {
                     domUtils.addClass(successPrompt, 'active');
                     clearInputValues() 
                     closeIconSuccess.click(function() {
                         domUtils.removeClass(successPrompt, 'active');
                     });
                 } else {
                     alert("Sign up failed.")
                 }
             }, 
             error: function(xhr, status, error) {
                 console.error("Form submission error:", status, error);
             }
         });
     return ;
 }   
    }

    
    // Select contries
    $.ajax({
        url: "Smember-signup.php",
        type: "POST",
        data: {
            action: "countries_select"
        },
        success: function(response) {
          $('#country').append(response);
        }
    });


    
 // PEEK PASSWORD

 let peekPasswordImg = $('#peek-password');
 peekPasswordImg.click(function() {
    if(password.attr('type') === 'password') {
        password.attr('type',  'text')
        peekPasswordImg.attr('src', "../../../IMAGES/GENERAL/close-eye.png");
    } else {
        password.attr('type', 'password');
        peekPasswordImg.attr('src', '../../../IMAGES/GENERAL/peek-password.png');
    }
 })
});

