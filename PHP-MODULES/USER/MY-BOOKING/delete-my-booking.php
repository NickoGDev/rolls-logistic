<?php
include '../../connection.php';



$id = $_GET['deleteId'];
$shipmentId = $_GET['shipmentId'];
$pickup_id = $_GET['pickupId'];
$delivery_id = $_GET['deliveryId'];

// DELETE user shippings
$sql_user_shipping = "DELETE FROM user_shippings where user_id = $id AND shipping_id = $shipmentId";
$result_user_shipping = mysqli_query($con, $sql_user_shipping);

// DELETE user pickup_countries
$sql_delete_pickup_countries = "DELETE FROM pickup_countries where user_id = $id AND pickup_id = $pickup_id";
$result_pickup_countries = mysqli_query($con, $sql_delete_pickup_countries);

// DELETE user delivery_countries
$sql_delete_delivery_countries = "DELETE FROM delivery_countries where user_id = $id AND delivery_id = $delivery_id";
$result_delivery_countries = mysqli_query($con, $sql_delete_delivery_countries);

if ($result_user_shipping && $result_pickup_countries && $result_delivery_countries) {
    header('location: ../../../PHP-MODULES/USER/MY-BOOKING/my-booking.php?id=' . $id . '');
} else {
    die('Error: ' . mysqli_error($con));
}
