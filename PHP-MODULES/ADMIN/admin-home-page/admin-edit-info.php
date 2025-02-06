<?php
include "../../connection.php";


// Fetch all data and sets in inputs tags
if (isset($_POST['action']) && $_POST['action'] === 'edit-info') {
    $query_select_info = "SELECT * FROM main_admin_account";
    $result_select_info = mysqli_query($con, $query_select_info);

    if ($result_select_info) {  // Check if the query executed successfully
        $row = mysqli_fetch_assoc($result_select_info);
        if ($row) {
            $stored_info = [
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'mobile' => $row['mobile'],
                'country' => $row['country'],
                'city' => $row['city'],
            ];
            echo json_encode($stored_info);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    } else {
        echo json_encode(['error' => 'Query failed']);
    }
};

// UPDATE DATA 

if (isset($_POST['action']) && $_POST['action'] === 'update-info-data') {
    $admin_id = $_POST['admin_id'];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_email = $_POST['email'];
    $new_mobile = $_POST['mobile'];
    $new_country = $_POST['country'];
    $new_city = $_POST['city'];

    $query_update_admin_info = "UPDATE main_admin_account 
                                    SET first_name = '$new_first_name' ,
                                        last_name = '$new_last_name' ,
                                        email = '$new_email' ,
                                        mobile = '$new_mobile' ,
                                        country = '$new_country' ,
                                        city = '$new_city'           
                                    WHERE 
                                        admin_id = $admin_id;
                                     ";
    $result_update_admin_info = mysqli_query($con, $query_update_admin_info);

    $new_info_sets = [];
    if ($result_update_admin_info) {
        $new_info_sets = [
            'first_name' => $new_first_name,
            'last_name' => $new_last_name,
            'email' => $new_email,
            'mobile' => $new_mobile,
            'country' => $new_country,
            'city' => $new_city
        ];
        echo json_encode($new_info_sets);
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
}
