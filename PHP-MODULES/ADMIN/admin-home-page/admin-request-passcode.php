<?php


include "../../connection.php";

// CHANGE PASSWORD USING EMAIL PASSCODE
if (isset($_POST['action']) && $_POST['action'] === 'change_passcode') {
    // query to change password using generated passcode
    $generated_passcode = $_POST['generated_passcode'];
    $id = $_POST['id'];

    $query_use_passcode = "UPDATE main_admin_account SET password = '$generated_passcode' WHERE admin_id = $id";
    $result_passcode = mysqli_query($con, $query_use_passcode);

    if ($result_passcode) {
        echo "retrieve_passcode";
    }
}


// CHANGED PASSWORD USING CHANGE PASS FORM
if (isset($_POST['action']) && $_POST['action'] === "input_change_pass") {
    $email_passcode = $_POST['email_passcode'];
    $confirm_password = $_POST['confirm_password'];
    $id = $_POST['id'];

    // Match the provided passcode
    $query_match_passcode = "SELECT * FROM main_admin_account WHERE BINARY password = '$email_passcode'";
    $result_match_passcode = mysqli_query($con, $query_match_passcode);

    if (mysqli_num_rows($result_match_passcode) > 0) {
        // Update password
        $query_changePassForm = "UPDATE main_admin_account SET password = '$confirm_password' WHERE admin_id = $id";
        $query_changePassForm_result = mysqli_query($con, $query_changePassForm);

        if ($query_changePassForm_result) {
            echo "success-change-pass";
        } else {
            echo "updating-password-failed";
        }
    } else {
        echo "invalid-passcode";
    }
}
