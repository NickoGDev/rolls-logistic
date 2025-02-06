<?php
include "../../../PHP-MODULES/connection.php";

$query_countries = "SELECT * FROM route_countries";
$result_countries = mysqli_query($con, $query_countries);

$all_countries = "";
if (
    isset($_POST['action']) &&
    $_POST['action'] === "all_countries" &&
    $result_countries
) {
    while ($row = mysqli_fetch_assoc($result_countries)) {
        $all_countries .= "<option>" . $row['countries'] . "</option>";
    }
    echo $all_countries;
}
