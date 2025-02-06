<?php

include "../../../PHP-MODULES/connection.php";


if (isset($_POST['submit'])) {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $mobile = $_POST['mobile'];
    $admin_email = $_POST['email'];

    // CHECK IF THERE WAS AN AUTHORIZED SIGNUP, IF THERE WAS AN EXISTING ADMIN
    $query_count_of_admin = "SELECT COUNT(*) AS count FROM main_admin_account";
    $result_count_of_admin = mysqli_query($con, $query_count_of_admin);


    // INVALIDATION PROMPT TRIGGER
    $unauthorized_user = "";

    if ($result_count_of_admin) {
        $row = mysqli_fetch_assoc($result_count_of_admin);
        $admin_count = $row['count'];

        if ($admin_count == 0) {
            $query_signup = "INSERT INTO main_admin_account
                                (first_name, last_name, password, country, city, mobile, email)
                                VALUES
                                ('$first_name', '$last_name', '$password', '$country', '$city', '$mobile', '$admin_email')";
            $result_signup = mysqli_query($con, $query_signup);
            $unauthorized_user = "authorized";
        } else {
            echo "unauthorized";
        }
    } else {
        echo "Error" . mysqli_error($con);
    }
}



// SELECT COUNTRIES
$query_countries = "SELECT countries FROM route_countries";
$result_countries = mysqli_query($con, $query_countries);

$all_countries = "";
if ($result_countries) {
    while ($row = mysqli_fetch_assoc($result_countries)) {
        $all_countries .= "<option>" . $row['countries'] . "</option>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin signup</title>
    <link rel="stylesheet" href="../../../STYLES/OVERALL/overall.css">
    <link rel="stylesheet" href="../../../STYLES/ADMIN/Madmin-signup/admin-signup.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="body-container">
        <div class="signup-container">
            <div class="signup-section">
                <div class="signup-col-seperator">
                    <div class="signup-left-section">
                        <div class="signup-lot">
                            <div class="left-header">
                                <div class="header-circular">
                                    <div class="left-header-logo">
                                        <img src="../../../IMAGES/GENERAL/logo.png" alt="">
                                        <label for="">Rolls</label>
                                    </div>
                                </div>
                                <div class="left-header-textCon">
                                    <p class="left-header-text">Rolls allow you to transport shipments worldwide.</p>
                                    <img src="../../../IMAGES//GENERAL/global-logistics.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="signup-right-section">
                        <div class="signup-lot">
                            <div class="signup-credential-con">
                                <div class="right-header">
                                    <div class="greeting-container">
                                        <img src="../../../IMAGES/GENERAL/animation-greeting.png" alt="">
                                    </div>
                                    <div class="right-header-greeting">
                                        <div class="right-header-row1">
                                            Create a
                                            <label>Main admin account</label>
                                        </div>
                                        <div class="invalidation-prompt" id="invalidation-prompt" invalid-trigger="<?= $unauthorized_user ?>">
                                            <div class="invalidation-section">
                                                <img class="authorization-img" id="authorization-img" src="../../../IMAGES/GENERAL/authorized-personel.jpg">
                                                <div class="invalidation-guide">
                                                    <div class="invalidation-textguides">
                                                        <label class="invalidation-guideT" id="invalidation-guideT" for=""></label>
                                                        <div class="invalidation-guideS" id="invalidation-guideS" for=""></div>
                                                        <label class="admin-email" id="admin-email" display-email="<?= $admin_email ?>"></label>
                                                    </div>
                                                    <div class="close-btn-container">
                                                        <div id="close-invalidation">Ok</div>
                                                        <a href="../../../PHP-MODULES/ADMIN/Madmin-login/Madmin-login.html" id="link-to-login"><label class="link-to-loginT">Login now</label></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-header-row2">
                                            <a class="create-acc-link" href="../../../PHP-MODULES/ADMIN/Madmin-login/Madmin-login.html">Already have an account?</a>
                                            <div class="row2-seperator"></div>
                                            <a class="forget-password-link" href="">Forget your password?</a>
                                        </div>
                                    </div>
                                </div>
                                <form id="create-account-form" method="POST" class="signup-inputs-con">
                                    <div class="signup-field-containers">
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">First name*</label>
                                            <input class="field-input" type="text" name="first-name" id="first-name-errorField">
                                            <div class="validation-error" id="first-name-errorPrompt">

                                            </div>
                                        </div>
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">Last name*</label>
                                            <input class="field-input" id="last-name-errorField" name="last-name" type="text">
                                            <div class="validation-error" id="last-name-errorPrompt">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup-field-containers">
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">Password*</label>
                                            <div class="peek-password-container">
                                                <input class="field-input" type="password" id="password-errorField" name="password" class="field-input" type="text">
                                                <button type="button" class="reveal-password-btn" id="peek-password-btn">
                                                    <img id="peek" src="../../../IMAGES/USER/SIGNUP/close-eye.png" alt="">
                                                </button>
                                            </div>
                                            <div class="validation-error" id="password-errorPrompt">

                                            </div>
                                        </div>
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">Email*</label>
                                            <input class="field-input" id="email-errorField" name="email" typecitycountry="text">
                                            <div class="validation-error" id="email-errorPrompt">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup-field-containers">
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">Country*</label>
                                            <select type="text" id="country-errorField" name="country" class="field-input">
                                                <option value="" selected style="display: none;">Select a country</option>
                                                <?= $all_countries ?>
                                            </select>
                                            <div class="validation-error" id="country-errorPrompt">

                                            </div>
                                        </div>
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">City*</label>
                                            <input type="text" id="city-errorField" name="city" class="field-input" type="text">
                                            <div class="validation-error" id="city-errorPrompt">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup-field-containers">
                                        <div class="signup-column-field">
                                            <label class="field-label" for="">Mobile*</label>
                                            <input class="field-input" id="mobile-errorField" name="mobile" type="text" maxlength="11">
                                            <div class="validation-error" id="mobile-errorPrompt">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-container">
                                        <button id="submit-button" type="submit" name="submit">submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../../JAVASCRIPT/ADMIN/Madmin-signup/Madmin-signup.js"></script>
</body>

</html>