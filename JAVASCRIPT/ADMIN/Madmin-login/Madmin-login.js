$(document).ready(function() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    let submitBtn = $('#submit-btn');

    submitBtn.click(function(event) {
        event.preventDefault();
        submissionData();
    });

    // INPUT FORM
    let inputEmail = $('#input-email');
    let inputPassword = $('#input-password');

    // FUNCTION TO ADD STYLE
    function addClassList(ele, classList) {
        ele.addClass(classList);
    }
    // FUNCTION TO REMOVE STYLE
    function removeClassList(ele, classList) {
        ele.removeClass(classList)
    }

    function styleErrorPrompt(errorPrompt, textDisplay, removeTxtDisplay, errorState) {
        if(errorState === "empty_error") {
            addClassList(errorPrompt, 'active');
            addClassList(textDisplay, 'active');
            removeClassList(removeTxtDisplay, 'active')
        } 
        else if(errorState === "empty_invalid") {
            addClassList(errorPrompt, 'active');
            addClassList(textDisplay, 'active');
            removeClassList(removeTxtDisplay, 'active')
        }
    }

    // PROCESS FOR SUBMISSION
    function submissionData() {
        let emailVal = inputEmail.val();
        let passwordVal = inputPassword.val();

        // AJAX to check if the account exists
        $.ajax({
            url: "Madmin-login.php",
            type: "POST",
            data: {
                action: "login_account",
                email: emailVal,
                password: passwordVal
            },
            dataType: "json",
            success: function(response) {
                // ERROR PROMPT
                let invalidPrompt = $('#invalid-prompt');
                let invalidButton = $('#close-invalidation-prompt');

                // Error Display text
                let invalidInputs = $('#invalid-inputs');
                let invalidEmpty = $('#invalid-empty');
                
                if(response.id && response.key) {
                    adminDirectToHomePage(response.id, response.key);
                    console.log('Ds')
                    removeClassList(invalidPrompt, 'active');
                } 
                else if (response.empty_error) {
                    styleErrorPrompt(invalidPrompt, invalidEmpty, invalidInputs, "empty_error");
                    invalidButton.click(function() {
                        removeClassList(invalidPrompt, 'active');
                    });
                } else {
                    styleErrorPrompt(invalidPrompt, invalidInputs, invalidEmpty, "empty_invalid");
                    invalidButton.click(function() {
                        removeClassList(invalidPrompt, 'active');
                    })
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                console.log(xhr.responseText); // Log the raw response text
            }
        });
    }


    // PEEK PASSWORD
    let peekButton = $('#peek-password-btn');
    let peekImg = $('#peek');

    peekButton.click(function() {
        if(inputPassword.attr('type') === 'password') {
            inputPassword.attr('type', 'text')
            peekImg.attr('src', '../../../IMAGES/USER/SIGNUP/close-eye.png')
        } else {
            peekImg.attr('src', '../../../IMAGES/USER/SIGNUP/peek-password.png')
            inputPassword.attr('type', 'password')
        }
    })
});


// Redirection Process id and key
function adminDirectToHomePage(id, key) {
    const homePageUrl = "../admin-home-page/admin-home.html";
    sessionStorage.setItem('adminId', id);
    sessionStorage.setItem('adminKey', key);

    window.location.href = homePageUrl;

    // let storedAdminId = sessionStorage.getItem('adminId');
    // let storedAdminKey = sessionStorage.getItem('adminKey');
    
    // let getterId = $('#getter-id');
    // let getterKey = $('#getter-key');

    // getterId.text(storedAdminId)
    // getterKey.text(storedAdminKey);
}