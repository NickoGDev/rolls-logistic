<?php

include '../../connection.php';
// MY-BOOKING-QUERY



// $encrypted_id = $_GET['id'];

// Use a 16-byte IV
// $iv = substr('your_iv_here12345', 0, 16);

// $decrypted_id = openssl_decrypt($encrypted_id, 'aes-256-cbc', 'your_secret_key', 0, $iv);

$id = $_GET['id'];

$sql_view_book = "
SELECT
    user_signup.id,
    user_shippings.shipping_id,
    user_shippings.declared_items,
    user_shippings.declared_weight,
    user_shippings.delicate_type,
    user_shippings.package_type,
    user_shippings.shipment_price,
    user_shippings.shipping_code,

    pickup_countries.pickup_id,
    pickup_countries.pickup_country,
    pickup_countries.transportation,
    pickup_countries.pickup_address,
    pickup_countries.pickup_date,

    delivery_countries.delivery_id,
    delivery_countries.delivery_country,
    delivery_countries.delivery_address,
    delivery_countries.arrival_date

FROM
    user_signup

JOIN
    user_shippings ON user_signup.id = user_shippings.user_id 

JOIN
    pickup_countries ON user_shippings.shipping_id = pickup_countries.pickup_id

JOIN
    delivery_countries ON user_shippings.shipping_id = delivery_countries.delivery_id

WHERE
    user_signup.id = $id

";

$result_view_book = mysqli_query($con, $sql_view_book);

$list_booking = "";
$deleteButtonContainer = '';
if ($result_view_book) {
    while ($row = mysqli_fetch_assoc($result_view_book)) {
        $id = $row['id'];

        $pickup_id = $row['pickup_id'];
        $pickup_date = date('m/d/Y', strtotime($row['pickup_date']));
        $pickup_address = $row['pickup_address'];

        $shipping_id = $row['shipping_id'];
        $declared_item = $row['declared_items'];
        $declared_weight = $row['declared_weight'];
        $delicate_type = $row['delicate_type'];
        $package_type = $row['package_type'];
        $shipment_price = $row['shipment_price'];
        $shipping_code = $row['shipping_code'];

        $pickup_country = $row['pickup_country'];

        $delivery_id = $row['delivery_id'];
        $delivery_country = $row['delivery_country'];
        $delivery_address = $row['delivery_address'];
        $arrival_date = date('m/d/Y', strtotime($row['arrival_date']));
        $transportation = $row['transportation'];

        $pickup_date = $row['pickup_date'];

        $deleteButtonContainer = '
        <div class="delete-prompt-container" id="delete-prompt" delete-counter = "' . $shipping_id . '">
            <div class="delete-prompt-section">
                <div class="delete-prompt-header">
                    <img src="../../../IMAGES/GENERAL/item-icon.png" alt="">
                    <div class="delete-prompt-guide">
                        <label class="text-guide" for="">Are you sure you want to delete this shipment?</label>
                        <div class="item-icon">
                            <div class="icon-item">
                                <img src="../../../IMAGES/GENERAL/delete-prompt.png" alt="">
                                <label class="cargo-item" for="">' . $declared_item . '</label>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="delete-button-container">
                    <a href="../../../PHP-MODULES/USER/MY-BOOKING/delete-my-booking.php?deleteId=' . $id .
            '&shipmentId=' . $shipping_id .
            '&pickupId=' . $pickup_id .
            '&deliveryId=' . $delivery_id . '"
                       class="delete-btn" id="delete-button">Delete</a>
        
                    <a class="cancel-btn" id="cancel-button" name="delete-button">Cancel</a>
                </div>
            </div>
        </div>';

        $list_booking .= '
        <div class="table-data-deleteSeperator">
            <a href="../../../PHP-MODULES/USER/VIEW-SHIPMENT/view-shipment.php?
            
            id= ' . $id .
            '&declared_item=' . $declared_item .
            '&shipment_price=' . $shipment_price .
            '&shipping_id=' . $shipping_id .
            '&shipment_price=' . $shipment_price .
            '&shipping_code=' . $shipping_code .
            '&declared_weight=' . $declared_weight .
            '&pickup_country=' . $pickup_country .
            '&pickup_id=' . $pickup_id .
            '&pickup_address=' . $pickup_address .
            '&pickup_date=' . $pickup_date .
            '&package_type=' . $package_type .
            '&delicate_type=' . $delicate_type .
            '&delivery_id=' . $delivery_id .
            '&delivery_country=' . $delivery_country .
            '&delivery_address=' . $delivery_address .
            '&arrival_date=' . $arrival_date .
            '&transportation=' . $transportation .
            '
            " class="table-data-seperator">

            <div class="table-data-leftSection">
                <div class="table-data-content">
                    <div class="table-date-contentHeader">
                        <img src="../../../IMAGES/GENERAL/star.png" alt="">
                        <label class="data-content" for=""> ' . $declared_item . ' &middot;</label>
                    </div>
                </div>
                <div class="table-data-content">
                    <label for="" class="data-gross-weight">Your Shipment Gross Weight was
                        <p class="weight-underline">' . $declared_weight . ' </p>
                        kg -
                    </label>
                    <label for="" class="data-delicate">
                        Declared as:
                        <p class="weight-underline"> ' . $delicate_type . '</p>
                        state.
                    </label>
                </div>
            </div>

            <div class="table-data-rightSection">
                <div class="table-data-content2">
                    Pickup Via:
                    <p class="left-underline">';

        if ($transportation == 'Plane') {
            $list_booking .= 'Plane';
        } elseif ($transportation == 'Vessel') {
            $list_booking .= 'Vessel';
        } elseif ($transportation == 'Inland') {
            $list_booking .= 'Inland';
            $transportationText = 'Inland';
        }
        $list_booking .= '</p>';

        $list_booking .= '<img src="';
        if ($transportation == 'Plane') {
            $list_booking .= '../../../IMAGES/GENERAL/transport/plane.png';
        } elseif ($transportation == 'Vessel') {
            $list_booking .= '../../../IMAGES/GENERAL/transport/vessel.png';
        } elseif ($transportation == 'Inland') {
            $list_booking .= '../../../IMAGES/GENERAL/transport/inland.png';
        }
        $list_booking .= '" alt="">
                </div>
                <div class="table-data-content2">
                    Pickup Date:
                    <p class="left-underline">' . $pickup_date . '</p>
                    <img class="date" src="../../../IMAGES/GENERAL/date.png" alt="">
                </div> 
            </div>
        </a> <!-- end of seperator-->

        ' . $deleteButtonContainer . '
         
        <div delete-counter = "' . $shipping_id . '" class="delete-icon-container" id="delete-trigger">
            <img class="delete-icon" src="../../../IMAGES/GENERAL/delete.png" alt="">
        </div>
    </div>

    ';
    }
}

if (!$result_view_book) {
    echo "Error";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My booking</title>
    <!--Font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CUSTOM-CSS -->
    <link rel="stylesheet" href="../../../STYLES/USER/MY-BOOKING/my-booking.css">
    <link rel="stylesheet" href="../../../STYLES/OVERALL/overall.css">
    <link rel="stylesheet" href="../../../STYLES/USER/HEADER/header.css">
</head>

<body>
    <!-- DARKEN-BODY -->
    <div class="darken-body" id="darken-body">

    </div>
    <!-- HEADER-CONTAINER -->
    <div class="header-container">
        <div class="header-sections">
            <div class="header-components">
                <div class="header-left-section">
                    <div class="logo-font">
                        <img class="logistic-logo" src="../../../IMAGES/GENERAL/logo.png" alt="">
                        <label for="">Rolls</label>
                    </div>
                    <div class="header-services">
                        <div class="services-navigation">
                            <?= '<a href="../../../PHP-MODULES/USER/SHIPMENT-FORM/shipment-form.php?id=' . $id . '">Shipment form</a>'; ?>
                            <a href="">My booking</a>
                        </div>
                    </div>
                </div>
                <div class="header-right-section">
                    <!-- <div class="personalization-container">
                        <img src="../../../IMAGES/GENERAL/account.png" alt="">
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="table-shipments-container">
        <div class="table-shipments">
            <table>
                <div class="header-table">
                    <label for="">Your Cargo List</label>
                </div>
                <tbody>
                    <tr>
                        <td>
                            <div class="table-data-container">
                                <?php
                                if ($list_booking) {
                                    echo $list_booking;
                                } else {
                                    echo "
                                    <div class='empty-transaction-container'> 
                                        <img src='../../../IMAGES/GENERAL/empty-shipment.png'>
                                        <label> No Scheduled Shipments </label>
                                    </div>
                                    <hr class='hr-empty'>
                                    ";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../../../JAVASCRIPT/USER/MY-BOOKING/my-booking.js"></script>
</body>

</html>