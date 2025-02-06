<?php

include "../../connection.php";

// Data
$id = $_GET['id'];
$shipping_id = $_GET['shipping_id'];
$declared_item = $_GET['declared_items'];
$declared_weight = $_GET['declared_weight'];
$shipment_price = $_GET['shipment_price'];
$shipping_code = $_GET['shipping_code'];
$delicate_type = $_GET['delicate_type'];
$package_type = $_GET['package_type'];

$pickup_id = $_GET['pickup_id'];
$pickup_country = $_GET['pickup_country'];
$pickup_address = $_GET['pickup_address'];
$transportation = $_GET['transportation'];

$delivery_id = $_GET['delivery_id'];
$delivery_country = $_GET['delivery_country'];
$delivery_address = $_GET['delivery_address'];
$arrival_date = date('m/d/Y', strtotime($_GET['arrival_date']));
$pickup_date = date('m/d/Y', strtotime($_GET['pickup_date']));

$booking_info = '
        
        <div class="cargo-horizon">
        <div class="cargo-lot">
            <div class="data-icon">
                <img src="../../../IMAGES/GENERAL/cargo-item.png" alt="">
            </div>
            <div class="cargo-info">
                <label for="" class="field-type">Cargo item</label>
                <div class="cargo-identification">
                    <label for="" class="cargo-item">' . $declared_item . '</label>
                    <label for="" class="delicate-state">Gross weight: ' . $declared_weight . ' kg</label>
                </div>
            </div>
        </div>
        <div class="cargo-lot">
            <div class="data-icon">
                <img src="../../../IMAGES/GENERAL/packaging.png" alt="">
            </div>
            <div class="cargo-info">
                <label for="" class="field-type">Packaging & State</label>
                <div class="cargo-identification">
                    <label for="" class="cargo-item">' . $delicate_type . ' </label>
                    <label for="" class="delicate-state">Packaging: (' . $package_type . ')</label>
                </div>
            </div>
        </div>
    </div>

    <div class="cargo-horizon">
    <div class="cargo-lot">
        <div class="data-icon">
            <img src="../../../IMAGES/GENERAL/pickup-country.png" alt="">
        </div>
        <div class="cargo-info">
            <label for="" class="field-type">Pickup country</label>
            <div class="cargo-identification">
                <label for="" class="cargo-item">' . $pickup_country . '</label>
                <label for="" class="delicate-state">Address: ' . $pickup_address . '</label>
            </div>
        </div>
    </div>
    <div class="cargo-lot">
        <div class="data-icon">
            <img src="../../../IMAGES/GENERAL/delivery-country.png" alt="">
        </div>
        <div class="cargo-info">
            <label for="" class="field-type">Delivery country</label>
            <div class="cargo-identification">
                <label for="" class="cargo-item">' . $delivery_country . ' </label>
                <label for="" class="delicate-state">Address: ' . $delivery_address . '</label>
            </div>
        </div>
    </div>
</div>



<div class="cargo-horizon">
<div class="cargo-lot">
    <div class="data-icon">
        <img src="../../../IMAGES/GENERAL/departure.png" alt="">
    </div>
    <div class="cargo-info">
        <label for="" class="field-type">Pickup date:</label>
        <div class="cargo-identification">
            <label for="" class="cargo-item" id="receipt-pickup-date">' . $pickup_date . '</label>
            <label for="" class="expected-time" id="receipt-pickup-time"></label>
        </div>
    </div>
</div>
<div class="cargo-lot">
    <div class="data-icon">
        <img src="../../../IMAGES/GENERAL/arrival.png" alt="">
    </div>
    <div class="cargo-info">
        <label for="" class="field-type">Arrival date: </label>
        <div class="cargo-identification">
            <label for="" class="cargo-item" id="receipt-arrivalDate">' . $arrival_date . ' </label>
            <label for="" class="expected-time" id="receipt-arrival-time"></label>
        </div>
    </div>
</div>
</div>';


$pricing_info = '
    <div class="mode-transpo">
        <div class="transpo-container">
            <label class="transpo-header" for="">Mode of Transportation</label>
            <div class="transpo-section">
                <img src="';

if ($transportation === 'Plane') {
    $pricing_info .= '../../../IMAGES/GENERAL/transport/plane.png';
} elseif ($transportation === 'Vessel') {
    $pricing_info .= '../../../IMAGES/GENERAL/transport/vessel.png';
} elseif ($transportation === 'Inland') {
    $pricing_info .= '../../../IMAGES/GENERAL/transport/inland.png';
} else {
    $pricing_info .= 'path/to/default/image.png';
}

$pricing_info .= '" alt="">
                <hr>
                <label class="prefered-transpo">' . $transportation . '</label>
            </div>
        </div>
    </div>';

$total_price = '
        <div class="mode-transpo">
        <div class="transpo-container">
            <label class="transpo-header" for="">Pricing</label>
            <div class="transpo-section-2">
                <div class="shipment-price-container">
                    <label class="currency-sign"> &#8369</label>
                    <div class="shipmnent-totalPrice">
                        ' . $shipment_price . '
                    </div>
                </div>
            </div>
        </div>
    </div>
        ';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--Font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="../../../STYLES/USER/VIEW-SHIPMENT/view-shipment.css">
    <link rel="stylesheet" href="../../../STYLES/OVERALL/overall.css">
    <link rel="stylesheet" href="../../../STYLES/USER/HEADER/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View your shipment</title>
</head>

<body>
    <!-- HEADER-CONTAINER -->
    <div class="header-container">
        <div class="header-sections">
            <div class="header-components">
                <div class="header-left-section">
                    <div class="logo-font">
                        <img class="logistic-logo" src="../../../IMAGES/GENERAL/logo.png" alt="">
                        <label for="">Rolls</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BODY-CONTAINER -->
    <div class="body-container">
        <div class="body-section" id="body-shipping-section">
            <div class="shipping-headlines">
                <div class="shipping-code-section">
                    <div class="shipping-code-container1">
                        <div class="shipping-code-content">
                            <div class="shipping-code-text1">
                                <div class="shipping-update-dataCon">
                                    <div class="shipment-admission-header">
                                        <div class="shipment-header-section">
                                            <img src="../../../IMAGES/GENERAL/update-header.png" alt="">
                                            <label class="shipping-statement" for="">Shipping updates</label>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="shipment-admission">
                                        <div class="shipment-admission-section">
                                            <div class="shipment-addmision-contents">
                                                <label class="shipping-text-status" for="">Shipping Status:</label>

                                                <div class="shipping-status-container" id="shipping-status-container" for="">
                                                    <img id="shipping-statusI" src="../../../IMAGES/GENERAL/aproved.png" alt="">
                                                    <label id="shipping-statusT" for="">To ship</label>
                                                </div>
                                            </div>
                                            <div class="shipment-addmision-contents">
                                                <label class="shipping-text-status" for="">Expected arrival date:</label>
                                                <div class="shipping-status-container" for="">
                                                    <img id="shipping-arrival-dateI" src="../../../IMAGES/GENERAL/date.png" alt="">
                                                    <label id="shipping-arrival-dateT" for=""><?= $arrival_date ?></label>
                                                </div>
                                            </div>
                                            <div class="shipment-addmision-contents">
                                                <label class="shipping-text-status" for="">Current location:</label>
                                                <div class="shipping-status-container" for="">
                                                    <img id="shipping-current-locationI" src="../../../IMAGES/GENERAL/current-location.png" alt="">
                                                    <label id="shipping-current-locationT" for=""><?= $pickup_country ?></label>
                                                </div>
                                            </div>
                                            <div class="shipment-addmision-contents">
                                                <label class="shipping-text-status" for="">Carrier name:</label>
                                                <div class="shipping-status-container" for="">
                                                    <img id="shipping-carrier-nameI" src="../../../IMAGES/GENERAL/carrier-name.png" alt="">
                                                    <label id="shipping-carrier-nameT" for="">Booing 567</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shipping-update-dataCon">
                                    <div class="shipment-administrative-update">
                                        <div class="administrative-container">
                                            <div class="administrative-section">
                                                <label class="administrative-header" for="">Pickup time</label>
                                                <div class="admin-time-format" id="admin-time-format">
                                                    <label class="administrative-pickup-timeT" id="update-pickup-time" for="">4</label>
                                                    <label for="" class="time-type" id="update-pickup-type">pm</label>
                                                </div>
                                            </div>
                                            <div class="administrative-section">
                                                <label class="administrative-header" for="">Departure time</label>
                                                <div class="admin-time-format" id="admin-time-format">
                                                    <label class="administrative-pickup-timeT" id="update-departure-time" for="">10</label>
                                                    <label for="" class="time-type" id="update-departure-type">pm</label>
                                                </div>
                                            </div>
                                            <div class="administrative-section">
                                                <label class="administrative-header" for="">Arrival time</label>
                                                <div class="time-format-seperator">
                                                    <div class="admin-time-format" id="admin-time-format">
                                                        <label class="administrative-pickup-timeT" id="update-arrival-time" for="">4</label>
                                                        <label for="" class="time-type" id="update-arrival-type">pm</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="administrative-section">
                                                <label class="administrative-header" for="">Departure time</label>
                                                <div class="admin-time-format" id="admin-time-format">
                                                    <label class="administrative-pickup-timeT" for="">10</label>
                                                    <label for="" class="time-type">pm</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shipping-code-container2">
                        <div class="shipping-code-content">
                            <div class="shipping-code-text2">
                                <div class="shipment-admission-header"><label class="shipping-statement" for="">Shipping code#</label></div>
                                <label class="shipping-code" for=""><?= $shipping_code ?></label>
                            </div>
                            <div class="shipping-image-container">
                                <img src="../../../IMAGES/GENERAL/shipping-code.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shipment-content-data">
                <div class="shipment-receipt">
                    <div class="shipment-text-logo">
                        <div class="receipt-section">
                            <img src="../../../IMAGES/GENERAL/receipt.png" alt="">
                            <label for="">Official receipt</label>
                        </div>
                    </div>
                </div>
                <div class="body-confirm-seperator">
                    <div class="body-contents">
                        <div class="booking-header">
                            <label for="">Shipment Information</label>
                        </div>
                        <div class="booked-information">
                            <?php
                            if (isset($booking_info)) {
                                echo $booking_info;
                            } else {
                                echo "Wala";
                            }  ?>
                        </div>
                    </div>
                    <div class="pricing-modeTranspo">
                        <div class="booking-header">
                            <label for="">Transportation & Pricing</label>
                        </div>
                        <div class="pricing-information">

                            <?php
                            if (isset($pricing_info)) {
                                echo $pricing_info;
                            }  ?>
                        </div>
                        <div class="transpo-divider">
                            <hr>
                        </div>
                        <div class="pricing-information">
                            <?php
                            if (isset($total_price)) {
                                echo $total_price;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../../JAVASCRIPT/USER/VIEW-SHIPMENT/view-shipment.js"></script>
    </div>
</body>

</html>