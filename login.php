<?php
session_start();
include "PHP-MODULES/connection.php";

$usernameError = "";
$passwordError = "";

$T_invalid_credential = "";

if (isset($_POST['submit-form'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM user_signup WHERE BINARY username = '$username' AND BINARY password = '$password'";
    $result = mysqli_query($con, $query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];

        // Store the username in a session variable
        $_SESSION['username'] = $username;

        header("location: PHP-MODULES/USER/SHIPMENT-FORM/shipment-form.php?id=$userId");
        exit();
    } else {
        $T_invalid_credential = 1;
        $invalidPrompt = '<div class="validation-constraint">
                            <div class="prompt-text">
                                <img src="IMAGES/GENERAL/warning-icon.png" alt="">
                                <label for="">Invalid <b>Username</b> or <b>Password</b>.</label>
                            </div>
                            <img class="close-icon" src="IMAGES/GENERAL/close-icon.png" id="invalid-btn" alt="">
                        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS links -->
    <link rel="stylesheet" href="STYLES/USER/LOGIN/login.css">
    <link rel="stylesheet" href="STYLES/OVERALL/overall.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div class="login-space">
        <!-- FORM_CONTAINER -->
        <div class="login-container">
            <div class="left-section">
                <div class="header-text">Roll Logistics</div>
                <div class="secondary-texts">
                    <p>Move your parcel around the country on time.</p>
                    <label for="">Deliver It With Extra Care!</label>
                </div>
                <a href="portal-page.php" class="home-page">
                    <div class="home-icon-label">
                        <img src="IMAGES/GENERAL/home.png" alt="">
                        <label for="">Rolls Home</label>
                    </div>
                </a>
            </div>
            <div class="right-section">
                <form action="" class="login-form" id="login-form" name="login-form" method="POST">
                    <div class="field-form" id="field-form">
                        <div class="validation-concern" id="validation-invalid-credential" Validation-Invalid-Credential="<?= $T_invalid_credential ?>">
                            <?php
                            if ($T_invalid_credential) {
                                echo $invalidPrompt;
                            } ?>
                        </div>
                        <div class="field-section">
                            <input type="text" class="form-input" id="username" name="username" placeholder="Username">
                        </div>
                        <div class="field-section">
                            <div class="password-container">
                                <input type="password" class="form-input" id="password" name="password" placeholder="Password">
                                <div class="peek-password" id="peek-password"><img id="imageDisplay" src="IMAGES/USER/LOGIN/close-eye.png" alt=""></div>
                            </div>
                        </div>
                        <button type="submit" id="submit-form" name="submit-form" class="form-submit">Login</button>
                        <!-- <div class="link">
                            <a id="button" href="newpassword.php">Change Password</a>
                        </div> -->
                        <hr>
                    </div>
                    <div class="create-account-container">
                        <a href="signup.php"><button type="button">Create new account</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="JAVASCRIPT/LOGIN/login.js"></script>
</body>

</html>