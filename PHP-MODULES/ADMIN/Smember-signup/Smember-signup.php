<?php
include "../../../PHP-MODULES/connection.php";

// SELECT TAG FOR COUNTRIES
if (isset($_POST['action']) && $_POST['action'] === 'countries_select') {
    $query_countries = "SELECT countries FROM route_countries";
    $result_countries = mysqli_query($con, $query_countries);

    $all_countries = "";
    if ($result_countries) {
        while ($row = mysqli_fetch_assoc($result_countries)) {
            $all_countries .= "<option class='country-options'>" . htmlspecialchars($row['countries'], ENT_QUOTES, 'UTF-8') . "</option>";
        }
    }
    echo $all_countries;
    exit;
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CHECK FOR DUPLICATES
if (isset($_POST['action']) && $_POST['action'] === 'check_duplicates') {
    // Inputs
    $email_candidate = $_POST['email_candidate'];
    $phone_candidate = $_POST['phone_candidate'];

    // Check for duplicate email
    $query_duplicate_email = "SELECT * FROM applicant_list WHERE BINARY applicant_email = '$email_candidate'";
    $result_duplicate_email = mysqli_query($con, $query_duplicate_email);

    // Check for duplicate phone
    $query_duplicate_phone = "SELECT * FROM applicant_list WHERE BINARY applicant_phone_number = '$phone_candidate'";
    $result_duplicate_phone = mysqli_query($con, $query_duplicate_phone);

    $response = [];
    if (mysqli_num_rows($result_duplicate_email) > 0) {
        $response['email'] = "duplicate_email";
    } else {
        $reponse['email'] = "";
    }
    if (mysqli_num_rows($result_duplicate_phone) > 0) {
        $response['phone'] = "duplicate_phone";
    } else {
        $reponse['phone'] = "";
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}


// Insert employee
$signup_state = "";
if (isset($_POST['action']) && $_POST['action'] === 'insert_employee') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_initial = $_POST['middle_initial'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];

    // Debugging: Log received data
    error_log("Received data: " . print_r($_POST, true));

    $query_insert_applicant = "INSERT INTO applicant_list (
applicant_first_name, applicant_last_name, applicant_middle_initial, applicant_email,
applicant_password, applicant_country, applicant_city, applicant_address, applicant_phone_number,
applicant_age, applicant_gender)
VALUES (
'$first_name', '$last_name', '$middle_initial', '$email', '$password', '$country', '$city',
'$address', '$phone_number', '$age', '$sex')";

    $result_insert_applicant = mysqli_query($con, $query_insert_applicant);

    if ($result_insert_applicant) {
        $signup_state = "signup_success";
    } else {
        $signup_state = "signup_failed";
    }
    echo $signup_state;
    exit; // Exit to ensure no further code is executed
}
