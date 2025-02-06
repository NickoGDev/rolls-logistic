<?php
include "../../connection.php";


// SELECT ALL COUNTRIES
if (isset($_POST['action']) && $_POST['action'] === 'select_countries') {
    $query_countries = "SELECT * FROM route_countries";
    $result_countries = mysqli_query($con, $query_countries);

    $all_countries = "";
    if ($result_countries) {
        while ($row = mysqli_fetch_assoc($result_countries)) {
            $all_countries .= "
                <option value =" . $row['countries'] . '>' . $row['countries'] . "</option>";
        }
        echo $all_countries;
    }
}
