<?php
// FORM CLEANSING

// signup success or not prompt
$signupSucess = 0;
$T_duplicate_username = 0;
$T_duplicate_mobile = 0;
$T_duplicate_email = 0;

// API flag
$verified_account = "";
$select_firstname = "";
$select_username = "";
$select_email = "";

// Prevent Default Login
$halt_username_signup = "";
$halt_mobile_signup = "";
$halt_email_signup = "";
// LOGIN PROMPTS
$loginSuccessPrompt = '  
                                <div class="validation-success-prompt">
                                    <div class="prompt-text">
                                        <img src="IMAGES/GENERAL/confirm.png" alt="">
                                        <label for="">Sign Up Successfully!</label>
                                    </div>
                                    <div class="login-link">
                                        <label for="">click to</label>
                                        <a href="login.php">Log In</a>
                                    </div>
                                    <img class="close-icon" src="IMAGES/GENERAL/close-icon.png" id="close-login-success" alt="">
                                </div>';

$duplicateUsernamePrompt = '<div class="validation-constraint">
                                <div class="prompt-text">
                                    <img src="IMAGES/GENERAL/warning-icon.png" alt="">
                                    <label for="">Username is already existing.</label>
                                </div>
                                <img class="close-icon" src="IMAGES/GENERAL/close-icon.png" id="close-duplicate-username" alt="">
                            </div>';

$duplicateEmailPrompt = '<div class="validation-constraint" id ="validation-duplicateEmail">
                            <div class="prompt-text">
                            <img src="IMAGES/GENERAL/warning-icon.png" alt="">
                            <label for="">Email is already taken.</label>
                        </div>
                        <img class="close-icon" src="IMAGES/GENERAL/close-icon.png" id="close-duplicate-email" alt="">
                        </div>
';
$duplicateMobilePrompt = '<div class="validation-constraint">
                            <div class="prompt-text">
                            <img src="IMAGES/GENERAL/warning-icon.png" alt="">
                            <label for="">Mobile is already existing.</label>
                            </div>
                            <img class="close-icon" src="IMAGES/GENERAL/close-icon.png" id="close-duplicate-mobile" alt="">
                        </div>';

if (isset($_POST['submit_button'])) {
    include "PHP-MODULES/connection.php";

    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    // constraint patterns
    $number_pattern = '/\d+/';
    $password_pattern = '/^(?=.*[!@#$%^&*(),.?":{}|<>])(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
    $mobile_pattern = '/\d{11}/';
    $email_pattern = '/@/';
    if (
        empty($username) || strlen($username) < 4 ||
        empty($firstname) || preg_match($number_pattern, $firstname) === 1 ||
        empty($lastname) || preg_match($number_pattern, $lastname) === 1 ||
        empty($password) || strlen($password) < 8 || preg_match($password_pattern, $password) === 0 ||
        empty($address) ||
        empty($mobile) || preg_match($mobile_pattern, $mobile) == 0 ||
        empty($email) || preg_match_all($email_pattern, $email) == 0
    ) {
        echo '';
    } else {
        //Invalid or Duplicate fields constraint 
        $sql = "SELECT * FROM user_signup WHERE BINARY username = '$username'";
        $result = mysqli_query($con, $sql);
        $numDuplicateUsername = mysqli_num_rows($result);

        $sql_duplicate_mobile = "SELECT * FROM user_signup WHERE BINARY mobile = '$mobile'";
        $result_dupMobile = mysqli_query($con, $sql_duplicate_mobile);
        $numDuplicateMobile = mysqli_num_rows($result_dupMobile);

        $sql_duplicate_email = "SELECT * FROM user_signup WHERE BINARY email = '$email'";
        $result_duplicate_email = mysqli_query($con, $sql_duplicate_email);
        $numDuplicateEmail = mysqli_num_rows($result_duplicate_email);

        if ($numDuplicateUsername > 0) {

            $halt_username_signup = 1;
            $T_duplicate_username = 1;
        } else if ($numDuplicateMobile > 0) {

            $halt_mobile_signup = 1;
            $T_duplicate_mobile = 1;
        } else if ($numDuplicateEmail > 0) {

            $halt_email_signup = 1;
            $T_duplicate_email = 1;
        } else {
            $signupSucess = 1;
            $verified_account = 1;
            $sql_signup = "INSERT INTO `user_signup` (username, first_name, last_name, password, user_address, mobile, email) 
                        VALUES ('$username', '$firstname', '$lastname', '$password', '$address', '$mobile', '$email')";
            $result_signup = mysqli_query($con, $sql_signup);
            if ($result_signup) {
                $sql_select_firstname_email = "SELECT 
                                                    username, first_name, email
                                                     FROM 
                                                        user_signup
                                                     ORDER BY 
                                                        id DESC
                                                     LIMIT 
                                                        1";
                $result_select_firstname_email = mysqli_query($con, $sql_select_firstname_email);

                if (mysqli_num_rows($result_select_firstname_email) > 0) {
                    $row = mysqli_fetch_assoc($result_select_firstname_email);

                    $select_firstname = $row['first_name'];
                    $select_email = $row['email'];
                    $select_username = $row['username'];
                }
            } else {
            }
            $userId = mysqli_insert_id($con);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--Font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!--CSS links-->
    <link rel="stylesheet" href="STYLES/PORTAL-PAGE/services.css">
    <link rel="stylesheet" href="STYLES/USER/SIGNUP/signup.css">
    <link rel="stylesheet" href="STYLES/OVERALL/overall.css">
    <!-- Google API -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <input type="hidden" id="verified-account" value="<?= $verified_account ?>" verify-firstname="<?= $select_firstname ?>" verify-username="<?= $select_username ?>" verify-email="<?= $select_email ?>">
    <div class="signup-space">
        <div class="form-container">
            <div class="form-section">
                <div class="form-header">
                    <div class="form-header-text">
                        <img class="signup-image" src="IMAGES/USER/SIGNUP/header-image.jpg" alt="">
                        <div class="form-text-guide">
                            <label for="">Sign up Form</label>
                            <p class="secondary-text">Create your account and start your session!</p>
                            <a href="login.php">Already have an account?</a>
                        </div>
                        <div class="validation-guide">
                            <div class="validation-concern" id="validation-duplicate-username" Validation-Duplicate-Username="<?= $T_duplicate_username ?>">
                                <?php
                                if ($T_duplicate_username) {
                                    echo $duplicateUsernamePrompt;
                                } ?>
                            </div>
                            <div class="validation-concern" id="validation-duplicate-mobile" Validation-Duplicate-Mobile="<?= $T_duplicate_mobile ?>">
                                <?php
                                if ($T_duplicate_mobile) {
                                    echo $duplicateMobilePrompt;
                                }
                                ?>
                            </div>
                            <div class="validation-concern" id="validation-duplicate-email" Validation-Duplicate-Email="<?= $T_duplicate_email ?>">
                                <?php
                                if ($T_duplicate_email) {
                                    echo $duplicateEmailPrompt;
                                }
                                ?>
                            </div>
                            <div class="validation-success" id="signup-valid" Login-Success="<?= $signupSucess ?>">
                                <?php
                                if ($signupSucess) {
                                    echo $loginSuccessPrompt;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="" id="signup-form" class="form-field" method="POST">
                    <div class="form-field-a">
                        <div class="form-contents">
                            <label for="">Username*</label>
                            <input type="text" id="username" name="username" placeholder="username" halt-username-signup="<?= $halt_username_signup ?>">
                            <p class="signup-error" id="username-error"></p>
                        </div>
                        <div class="form-contents">
                            <label for="">Password*</label>
                            <div class="password-overlay">
                                <input type="password" id="password" name="password" placeholder="password">
                                <div class="peek-password" id="toggle-password"><img id="password-image" src="IMAGES/USER/SIGNUP/peek-password.png" alt=""></div>
                            </div>
                            <p class="signup-error" id="password-error"></p>
                        </div>
                    </div>
                    <div class="form-field-a">
                        <div class="form-contents">
                            <label for="">Current address*</label>
                            <input type="text" id="address" name="address" placeholder="address">
                            <p class="signup-error" id="address-error"></p>
                        </div>
                    </div>
                    <div class="form-field-a">
                        <div class="form-contents">
                            <label for="">First name*</label>
                            <input type="text" id="firstname" name="firstname" placeholder="first name">
                            <p class="signup-error" id="firstname-error"></p>
                        </div>
                        <div class="form-contents">
                            <label for="">Last name*</label>
                            <input type="text" id="lastname" name="lastname" placeholder="last name">
                            <p class="signup-error" id="lastname-error"></p>
                        </div>
                    </div>
                    <div class="form-field-a">
                        <div class="form-contents">
                            <label for="">Contact number*</label>
                            <input type="tel" id="mobile" name="mobile" placeholder="ex: 09556654021" maxlength="11" oninput="validateMobileInput(this)" halt-mobile-signup="<?= $halt_mobile_signup ?>">
                            <p class="signup-error" id="mobile-error"></p>
                        </div>
                        <div class="form-contents">
                            <label for="">Email*</label>
                            <input type="text" id="email" name="email" placeholder="ex: john@gmail.com" halt-email-signup="<?= $halt_email_signup ?>">
                            <p class="signup-error" id="email-error"></p>
                        </div>
                    </div>
                    <div class="submit-button">
                        <button type="submit" id="signup-button" name="submit_button">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="JAVASCRIPT/SIGN-UP/sign-up.js"></script>
</body>

</html>