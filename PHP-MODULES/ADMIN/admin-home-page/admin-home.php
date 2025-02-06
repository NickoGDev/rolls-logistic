<?php
include "../../connection.php";


if (isset($_POST['action']) && $_POST['action'] === "admin_credential") {
    $id = $_POST['id'];
    $key = $_POST['key'];

    $sql_main_admin = "SELECT * FROM main_admin_account WHERE administrative_key = '$key'";
    $result_main_admin = mysqli_query($con, $sql_main_admin);

    $admin_personal_data = [];
    if (mysqli_num_rows($result_main_admin) > 0) {
        $row = mysqli_fetch_assoc($result_main_admin);

        $admin_first_name = $row['first_name'];
        $admin_last_name = $row['last_name'];
        $admin_country = $row['country'];
        $admin_email = $row['email'];
        $admin_mobile = $row['mobile'];
        $admin_city = $row['city'];

        $admin_personal_data = [
            'first_name' =>  $admin_first_name,
            'last_name' => $admin_last_name,
            'country' => $admin_country,
            'email' => $admin_email,
            'mobile' => $admin_mobile,
            'city' => $admin_city
        ];
        echo json_encode($admin_personal_data);
    } else {
        echo json_encode("Error");
    }
}
