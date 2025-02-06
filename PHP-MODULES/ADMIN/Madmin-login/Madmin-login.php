<?php

include "../../../PHP-MODULES/connection.php";

function generateRandomCode()
{
    $length = 8;
    $capitalLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $smallLetters = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialChars = '@$&_?';

    $code = substr(str_shuffle($capitalLetters), 0, 1);
    $code .= substr(str_shuffle($smallLetters), 0, 4);
    $code .= substr(str_shuffle($numbers), 0, 1);
    $code .= substr(str_shuffle($specialChars), 0, 1);

    $remainingLength = $length - strlen($code);
    $allChars = $capitalLetters . $smallLetters . $numbers . $specialChars;
    $code .= substr(str_shuffle($allChars), 0, $remainingLength);

    return str_shuffle($code);
}

$main_administrative_key = generateRandomCode();

if (isset($_POST['action']) && $_POST['action'] === 'login_account') {

    $email = $_POST['email'] ?? ''; // Default to empty string if not set
    $password = $_POST['password'] ?? ''; // Default to empty string if not set

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo json_encode(['empty_error' => 'Email or password must not be empty']);
        exit;
    }

    // Query
    $query_login = "SELECT * FROM main_admin_account WHERE BINARY email = '$email' AND BINARY password = '$password'";
    $result_login = mysqli_query($con, $query_login);

    if (mysqli_num_rows($result_login) > 0) {
        $row = mysqli_fetch_assoc($result_login);
        $Madmin_id = $row['admin_id'];

        // UPDATE administrative key everytime main admin log in
        $query_admin_key = "UPDATE main_admin_account SET administrative_key = '$main_administrative_key' WHERE admin_id = '$Madmin_id'";
        $result_admin_key = mysqli_query($con, $query_admin_key);

        $key = [];
        if ($result_admin_key) {
            $key = [
                'id' => $Madmin_id,
                'key' => $main_administrative_key
            ];
            echo json_encode($key);
        }
    } else {
        $key = ['invalid' => 'invalid'];
        echo json_encode($key);
        exit; // Stop script execution to avoid any extra output
    }
}
