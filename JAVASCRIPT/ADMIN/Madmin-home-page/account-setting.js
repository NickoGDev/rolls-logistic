$(document).ready(function() {

    // Display image
    let imgInput = $('#img-input');
    let imgDisplay = $('#img-display');
    let uploadButtonSection = $('.upload-button-section');
    let errorMessage = $('#upload-error');
    

    let savedImagePath = localStorage.getItem('uploadedImgPath');
    if (savedImagePath) {
        imgDisplay.attr('src', savedImagePath).show(); // Display the saved image
    }


    // $('#new-country').selectpicker({
    //     container: 'body',  // Ensures the dropdown is not constrained by parent elements
    //     dropupAuto: false   // Forces dropdown to open downwards
    // });

    imgInput.change(function() {
        let imgFile = this.files[0];
    
        if (imgFile) {
            uploadButtonSection.addClass('active');
            imgDisplay.attr('src', URL.createObjectURL(imgFile)).show(); // Show the selected image
    
            uploadButtonSection.on('click', function() {
                let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                let maxSize = 5242880; 
    
                if (!imgFile) {
                    addMessage(errorMessage, 'Please select an image.');
                } else if (!allowedTypes.includes(imgFile.type)) {
                    addMessage(errorMessage, "Please select a valid image file (PNG, JPG, JPEG).");
                } else if (imgFile.size > maxSize) {
                    addMessage(errorMessage, 'Image must not exceed 5MB.');
                } else {
                    let formData = new FormData();
                    formData.append('file', imgFile);
    
                    $.ajax({
                        url: "../../../PHP-MODULES/ADMIN/admin-home-page/admin-upload-profile.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.trim() === "1") {
                                alert("Image uploaded successfully.");
                                uploadButtonSection.removeClass('active');

                                let imagePath = "../../../IMAGES/ADMIN/profile-picture/" + imgFile.name;
                                localStorage.setItem('uploadedImgPath', imagePath);
                            } else {
                                addMessage(errorMessage, response);
                            }
                        },
                        error: function() {
                            addMessage(errorMessage, 'An error occurred during the upload. Please try again.');
                        }
                    });
                }
            });
        }
    });
    
    
     // Retrieve the stored values from sessionStorage, that occur from Madmin-login.js
     let storedAdminId = sessionStorage.getItem('adminId');
     let storedAdminKey = sessionStorage.getItem('adminKey');

    // display information
     let firstNameDisplay = $('#admin-first-name, #profile-first-name');
     let lastNameDisplay = $('#admin-last-name, #profile-last-name');
     let countryDisplay = $('#admin-country');
     let emailDisplay = $('#admin-email, #profile-email');
     let mobileDisplay = $('#admin-mobile');
     let cityDisplay = $('#admin-city');

    // EDITING INPUTS
    let newFirstName = $('#new-first-name');
    let newLastName = $('#new-last-name');
    let newEmail = $('#new-email');
    let newMobile = $('#new-mobile');
    let newCountry = $('#new-country');
    let newCity = $('#new-city');

    // ERROR PROMPTS
    let firstNameError = $('#first-name-error');
    let lastNameError = $('#last-name-error');
    let emailError = $('#email-error');
    let mobileError = $('#mobile-error');
    let countryError = $('#country-error');
    let cityError = $('#city-error');

     // FUNCTIONS
     function addClass(ele, classList) {
        ele.addClass(classList)
     }
     function removeClass(ele, classList) {
        ele.removeClass(classList)
     }

     function addMessage(ele, message) {
        ele.text(message);
     }

     function removeMessage(ele) {
        ele.text('');
     }



    // Login process
     $.ajax({
        url: "../../../PHP-MODULES/ADMIN/admin-home-page/admin-home.php",
        type: "POST",
        data: {
            action: "admin_credential",
            id: storedAdminId,
            key: storedAdminKey
        }, 
        dataType: "json",
        success: function(response) {
            if(response.first_name && response.last_name && response.country && response.email && response.mobile && response.city) {
                firstNameDisplay.text(response.first_name)
                lastNameDisplay.text(response.last_name)
                countryDisplay.text(response.country)
                emailDisplay.text(response.email)
                mobileDisplay.text(response.mobile)
                cityDisplay.text(response.city)
            } 
        },
        error: function(xhr, status, error) {
            console.log(status)
            console.log("Error: ", error);
                console.log(xhr.responseText);
        }
     });

          // AJAX to get the admin information
          function displayPersonalInfo(first_name, last_name, email,  mobile, country, city) {
            firstNameDisplay.text(first_name)
            lastNameDisplay.text(last_name)
            countryDisplay.text(country)
            emailDisplay.text(email)
            mobileDisplay.text(mobile)
            cityDisplay.text(city)
        }

        // FUNCTION TO CHECK EMPTY INPUTS
        function checkEmptyInputs(input, classList, inputDisplay, inputMessage) {
            if($.trim(input.val()) !== '') {
                removeClass(input, classList);
                removeMessage(inputDisplay)
                return true;
            } else {
                addClass(input, classList);
                addMessage(inputDisplay, inputMessage)
                return false;
            }
        }

        // FUNCTION TO CHECK EMPTY INPUTS WHEN THE ELEMENT LOSE ITS FOCUS
        function blurCheckEmptyInputs(input, classList, inputDisplay, inputMessage) {
            input.on('blur', function() {
                checkEmptyInputs(input, classList, inputDisplay, inputMessage);
            });

            // check the empty inputs per type.
            input.on('input', function() {
                if($.trim(input.val()) !== '') {
                    removeClass(input, classList);
                    removeMessage(inputDisplay)
                } else {
                    addClass(input, classList);
                    addMessage(inputDisplay, inputMessage)
                }
            });
        }
        // FUNCTION TO CHECK IF THE ELEMENT LOSE ITS FOCUS
        blurCheckEmptyInputs(newFirstName, 'invalid', firstNameError, "First name must not be empty.");
        blurCheckEmptyInputs(newLastName, 'invalid', lastNameError, "Last name must not be empty.");
        blurCheckEmptyInputs(newEmail, 'invalid', emailError, "Email must not be empty.");
        blurCheckEmptyInputs(newMobile, 'invalid', mobileError, "Mobile must not be empty.");
        blurCheckEmptyInputs(newCountry, 'invalid', countryError, "Country must not be empty.");
        blurCheckEmptyInputs(newCity, 'invalid', cityError, "City must not be empty.");


        // USABLE PATTERNS
        let numericPatterns = /[0-9]/g; 
        let alphabetPatterns = /[A-Za-z]/g;
        let specialCharacterPatterns = /[!@#$%^&*()_+={}\[\]:;"``'<>,.?/\\|~-]/g;

        // FUNCTION TO CHECK INVALID CHARACTERS

        // FUNCTION TO REPLACE SPECIAL CHARACTERS
        clearSpecialCharac(newFirstName);
        clearSpecialCharac(newLastName);
        clearSpecialCharac(newCity);
        clearSpecialCharac(newMobile);

        function clearSpecialCharac(ele) {
            ele.on('input', function() {
                let currentValue = $(this).val();
                let newValue = currentValue.replace(specialCharacterPatterns, '');
                $(this).val(newValue);
            })
        }

        clearNumeric(newFirstName)
        clearNumeric(newLastName)
        clearNumeric(newCity)
        
        // FUNCTION TO CLEAR ALL NUMERIC
        function clearNumeric(ele) {
            ele.on('input', function() {
                let currentValue = $(this).val();
                let newValue = currentValue.replace(numericPatterns, '');
                $(this).val(newValue);
            })
        }

        clearAlphabetInput(newMobile)
        // FUNCTION TO CLEAR ALL ALPHABET
        function clearAlphabetInput(ele) {
            ele.on('input', function() {
                let currentValue = $(this).val();
                let newValue = currentValue.replace(alphabetPatterns, '');
                $(this).val(newValue);
            })
        }

        // FUNCTION TO CHECK @ IN FIELD
        function checkEmailAt(input, classList, displayError, message) {
            if(!/[@]/g.test(input.val())) {
                addClass(input, classList);
                addMessage(displayError, message);
                return false;
            } else {
                removeClass(input, classList);
                removeMessage(displayError, message);
                return true;
            }
        }

     // AJAX FUNCTION TO OPEN EDITING PROMPT,
     // GET THE RECENT DATA FROM THE ADMIN INFO, IT SERVED AS A GUIDE FOR EDITING INFO.
     $('.edit-info-con').click(function() {
        $.ajax({
            url: "../../../PHP-MODULES/ADMIN/admin-home-page/admin-edit-info.php",
            type: "POST",
            dataType: "json",
            data: {
                action: 'edit-info',
            },
            success: function(response) {

                    // Clear possible error before opening the prompt
                    removeClass(newFirstName, 'invalid');
                    removeMessage(firstNameError);

                    removeClass(newLastName, 'invalid');
                    removeMessage(lastNameError);

                    removeClass(newEmail, 'invalid');
                    removeMessage(emailError);

                    removeClass(newMobile, 'invalid');
                    removeMessage(mobileError);

                    removeClass(newCountry, 'invalid');
                    removeMessage(countryError);

                    removeClass(newCity, 'invalid');
                    removeMessage(cityError);

                    // Put all values in inputs
                    newFirstName.val(response.first_name);
                    newLastName.val(response.last_name);
                    newEmail.val(response.email);
                    newMobile.val(response.mobile);
                    newCountry.val(response.country);
                    newCity.val(response.city);

            },
            error: function(xhr, status, error) {
                console.error("AJAX error: ", error);
                console.error("Status: ", status);
                console.error("Response Text: ", xhr.responseText);
                alert('An error occurred while making the request.');
            }
        });
     });
    

     // INIATIATE UPDATE DATA, WHEN PROMPT APPEAR
     $('#update-information-btn').click(function(event) {
        event.preventDefault();

        // FORM VALIDATION
        let isValid = true;

        isValid &= checkEmptyInputs(newFirstName, 'invalid', firstNameError, "First name must not be empty.");
        isValid &= checkEmptyInputs(newLastName, 'invalid', lastNameError, "Last name must not be empty.");
        isValid &= checkEmptyInputs(newEmail, 'invalid', emailError, "Email must not be empty.");
        isValid &= checkEmptyInputs(newMobile, 'invalid', mobileError, "Mobile must not be empty.");
        isValid &= checkEmptyInputs(newCountry, 'invalid', countryError, "Country must not be empty.");
        isValid &= checkEmptyInputs(newCity, 'invalid', cityError, "City must not be empty.");

        isValid &= checkEmailAt(newEmail, 'invalid', emailError, "Email must contain @.");
        console.log(checkEmailAt(newEmail, 'invalid', emailError, "Email must contain @."))
        if(!isValid) {
            console.log('Stop')
            return;
        }  else {
            $.ajax({
                url: "../../../PHP-MODULES/ADMIN/admin-home-page/admin-edit-info.php",
                type: "POST",
                data: {
                    action: "update-info-data",
                    admin_id: storedAdminId,
                    first_name: newFirstName.val(),
                    last_name: newLastName.val(),
                    email: newEmail.val(),
                    mobile: newMobile.val(),
                    country: newCountry.val(),
                    city: newCity.val()
                },
                success: function(response) {
                    console.log(response)
                    let data = typeof response === 'string' ? JSON.parse(response) : response;

                    console.log(data); 
                
                    if (data.error) {
                        console.log("Error: " + data.error);
                    } else {
                        displayPersonalInfo(data.first_name, data.last_name, data.email, data.mobile, data.country, data.city);

                        var myModal = bootstrap.Modal.getInstance($('#edit-prompt'));
                        if (myModal) {      
                            myModal.hide();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX error:", error);
                    console.log(status);
                    console.log(xhr.responseText);
                }
            })
        }
    });

     // RIGHT SIDE BAR NAVIGATION
     $('.contents-navigation-section').click(function() {
        // reset style
        $('.contents-navigation-section').removeClass('active');

        $(this).addClass('active');
    });


    // RIGHT NAVIGATION BUTTONS MANIPULATION
    let selectNavigationProfile = $('#select-navigation-profile');
    let selectNavigationSecurity = $('#select-navigation-security');

    addClass(selectNavigationProfile, 'active')
    // RIGHT NAVIGATION PAGES
    let navigationControllerProfileCon = $('#navigation-controller-profile');
    let navigationControllerSecurityCon = $('#navigation-controller-security');

    selectNavigationProfile.show();
    navigationControllerSecurityCon.hide();

    // navigationControllerProfileCon.hide();
    // navigationControllerSecurityCon.show();
    
    selectNavigationProfile.click(function() {
        navigationControllerProfileCon.show(); 
        navigationControllerSecurityCon.hide();
    });

    selectNavigationSecurity.click(function() {
        navigationControllerSecurityCon.show();
        navigationControllerProfileCon.hide(); 
    })  

     // SELECT TAG FOR COUNTRIES
     $.ajax({
        url: "../../../PHP-MODULES/ADMIN/admin-home-page/countries.php",
        type: "POST",
        data: {
            action: "select_countries"
        },
        success: function(response) {
            if(response) {
                $('#new-country').append(response);
            }
        }
     });


     // EMAIL REQUEST FOR PASSWORD
     (function() {
        emailjs.init('VAjfSI3HxAPgNO7W-');
    })();
    
    let forgotPasswordBtn = $('#request-password-btn');

    function generatePassword(length, options) {
        const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numbers = '0123456789';
        const specialChars = '!@#&_?';
        
        let characters = lowercaseChars;
        
        if (options.includeUppercase) characters += uppercaseChars;
        if (options.includeNumbers) characters += numbers;
        if (options.includeSpecial) characters += specialChars;

        let randomGeneratedPassword = '';
        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            randomGeneratedPassword += characters[randomIndex];
        }
        return randomGeneratedPassword;
    }

    // Configuration for password generation
    const length = 8; // 
    const options = {
        includeUppercase: true,
        includeNumbers: true,
        includeSpecial: true
    };


    let randomGeneratedPassword = generatePassword(length, options);
    console.log('Generated Password:', randomGeneratedPassword);

    // Add click event listener to the forgot password button
    forgotPasswordBtn.click(function() {
        
        // Retrieve the text values from the labels
        let emailDisplay = $('#profile-email').text().trim(); // Assuming ".com" needs to be added
        let firstNameDisplay = $('#profile-first-name').text().trim();
        
        
        // Prepare the parameters for EmailJS
        let recoveryParams = {
            email_recipient: emailDisplay,
            message: randomGeneratedPassword,
            to_name: firstNameDisplay
        };
    
        // Send the form data using EmailJS
        emailjs.send('service_iy8zun2', 'template_2gwzgjt', recoveryParams)
        .then(function() {
            console.log('SUCCESS!'); 
            
            // Update the password with generated passcode

            $.ajax({
                url: "../../../PHP-MODULES/ADMIN/admin-home-page/admin-request-passcode.php",
                type: "POST",
                data: {
                    action: 'change_passcode',
                    generated_passcode: recoveryParams.message,
                    id: storedAdminId
                },

                success: function(response) {
                    console.log(response)
                    if ($.trim(response) === 'retrieve_passcode') {
                        // show the change pass form
                        $('.change-passwordInput-lot').attr('class', 'change-passwordInput-lot-active');
                        localStorage.setItem('toggleChangePasswordForm', 'change-passwordInput-lot-active');
                    } 
                    // else {
                    //     $('.change-passwordInput-lot').attr('class', 'change-passwordInput-lot');
                    // }
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });


            // Close the modal
            var confirmModal = bootstrap.Modal.getInstance($('#confirmationRetrieveCode'));
            if(confirmModal) {
                confirmModal.hide();
            }
            
        }, function(error) {
            console.log('FAILED...', error); // Error feedback
            alert('There was an error sending your message. Please try again later.');
        });
    });

    // AJAX FOR ACCOUNT CHANGE PASSWORD USING EMAIL PASSCODE

    // CHECK EMPTY IF INPUT LOSE FOCUS

    blurCheckEmptyInputs($('#email-passcode'), 'invalid', $('#passcode-error'), "Email passcode must not be empty.");
    blurCheckEmptyInputs($('#new-password'), 'invalid', $('#new-password-error'), "New password must not be empty.");
    blurCheckEmptyInputs($('#confirm-password'), 'invalid', $("#confirm-password-error"), "Confirm password must not be empty.");

    $('.change-passwordInput-lot-section').submit(function(event){
        event.preventDefault();

        let isValid = true;

        let changePasswordRequirements = {
            emailPasscode: $('#email-passcode'),
            newPassword: $('#new-password'),
            confirmPassword:  $('#confirm-password')
        }
        let changePasswordError = {
            emailPasscodeError: $('#passcode-error'),
            newPasswordError: $('#new-password-error'),
            confirmPasswordError: $("#confirm-password-error")
        };

        isValid &=  checkEmptyInputs(changePasswordRequirements.emailPasscode, 'invalid', changePasswordError.emailPasscodeError, "Email passcode must not be empty.");
        isValid &= checkEmptyInputs(changePasswordRequirements.newPassword, 'invalid', changePasswordError.newPasswordError, "New password must not be empty.");
        isValid &= checkEmptyInputs(changePasswordRequirements.confirmPassword, 'invalid', changePasswordError.confirmPasswordError, "Confirm password must not be empty.");

        // CHECK IF NEW PASSWORD AND CONFIRM PASSWORD WAS EQUAL
        if($.trim(changePasswordRequirements.newPassword.val()) !== $.trim(changePasswordRequirements.confirmPassword.val())) {
            addClass(changePasswordRequirements.newPassword, 'invalid');
            addClass(changePasswordRequirements.confirmPassword, 'invalid');

            addMessage(changePasswordError.newPasswordError, "New password and confirm password must match.");
            addMessage(changePasswordError.confirmPasswordError, "New password and confirm password must match.");
            return;
        }

        if(!isValid) {
            return;
        }

        // AJAX SENT PASSWORD INPUTS TO CHANGE
        $.ajax({
            url: "../../../PHP-MODULES/ADMIN/admin-home-page/admin-request-passcode.php",
            type: "POST",
            data: {
                action: "input_change_pass",
                email_passcode: changePasswordRequirements.emailPasscode.val(),
                confirm_password: changePasswordRequirements.confirmPassword.val(),
                id: storedAdminId
            },
            success: function(response) {
                if ($.trim(response) === 'success-change-pass') {
                    // hide the change pass form
                    $('.change-passwordInput-lot-active').attr('class', 'change-passwordInput-lot');
                    localStorage.setItem('removeChangePassForm', 'change-passwordInput-lot');

                    changePasswordRequirements.emailPasscode.val('');
                    changePasswordRequirements.newPassword.val('');
                    changePasswordRequirements.confirmPassword.val('');
                    
                } else if ($.trim(response) === 'invalid-passcode') {
                    alert('Invalid passcode.');
                } else {
                    alert(response);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", error, status);
            }
        });
                   
    });

    // Local storages
    let savedChangePasscodeForm = localStorage.getItem('toggleChangePasswordForm');
    let removeChangePassForm = localStorage.getItem('removeChangePassForm')
    // let removesavedChangePasscodeForm = 
    if(savedChangePasscodeForm) {
        $('.change-passwordInput-lot').attr('class', savedChangePasscodeForm);
    } 
    if(removeChangePassForm) {
        $('.change-passwordInput-lot-active').attr('class', savedChangePasscodeForm);
    }

    // window.onload = function() {
    //     var myModal = new bootstrap.Modal(document.getElementById('success-email-authenticator'));
    //     myModal.show();
    // };
    // let isValid = true;
    // isValid = isValid && true;
    // if(!isValid) {
    //     console.log(isValid)
    // }
});