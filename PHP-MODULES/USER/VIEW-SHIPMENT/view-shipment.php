<?php

include "../../connection.php";

// Data
$id = $_GET['id'];
$shipping_id = $_GET['shipping_id'];
$declared_item = $_GET['declared_item'];
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
            <label for="" class="expected-time" id="receipt-pickup-time">8 am</label>
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
            <label for="" class="expected-time" id="receipt-arrival-time">2 pm</label>
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
    <link rel="stylesheet" href="../../../STYLES/WEATHER-APP/weather.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shipment</title>
</head>

<body>
    <input type="hidden" id="weather-inputs" pickup-country="<?= $pickup_country ?>" delivery-country="<?= $delivery_country ?>">
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
                            <?= '<a href="../../../PHP-MODULES/USER/MY-BOOKING/my-booking.php?id=' . $id . '">My booking</a>'; ?>
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
    <!-- BODY-CONTAINER -->
    <div class="body-container">
        <div class="body-section" id="body-shipping-section">
            <div class="shipment-admission-header">
                <div class="shipment-header-directory">
                    <div class="shipment-header-section">
                        <img src="../../../IMAGES/GENERAL/update-header.png" alt="">
                        <label class="shipping-statement" for="">Shipping updates</label>
                    </div>
                    <div class="shipment-directory">
                        <div class="shipment-directory-section">
                            <label class="shipment-pickup-directory" for="">
                                <?php
                                echo $pickup_country
                                ?>
                            </label>
                            <?php
                            echo ' <img class="shipment-directory-courier" src="';

                            if ($transportation === 'Plane') {
                                echo '../../../IMAGES/GENERAL/transport/plane.png';
                            } elseif ($transportation === 'Vessel') {
                                echo '../../../IMAGES/GENERAL/transport/vessel.png';
                            } elseif ($transportation === 'Inland') {
                                echo '../../../IMAGES/GENERAL/transport/inland.png';
                            } else {
                                echo 'path/to/default/image.png';
                            }
                            echo '" alt="">';
                            ?>
                            <label class="shipment-delivery-directory" for="">
                                <?php
                                echo $delivery_country
                                ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shipping-headlines">
                <div class="shipping-code-section">
                    <div class="shipping-code-container1">
                        <div class="shipping-code-content">
                            <div class="shipping-code-text1">
                                <div class="shipping-update-dataCon">
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
                                                <label class="administrative-header" for="">Pickup time:</label>
                                                <div class="time-format-seperator">
                                                    <div class="update-delay-time" id="update-delay-time">
                                                        <div class="newly-time-clock">
                                                            <label class="new-time-matter" id="new-time-pickup" new-time-pickup="<?= "2:35" ?>" for=""></label>
                                                            <label class="new-format-matter" id="new-time-pickupF" new-time-pickupF="<?= "pm" ?>" for=""></label>
                                                        </div>
                                                        <div class="newly-updateT" id="pickup-time-new"></div>
                                                    </div>
                                                    <div class="admin-time-format" id="admin-time-format">
                                                        <label class="administrative-pickup-timeT" id="old-pickup-time" old-pickup-time="<?= "7" ?>" for=""></label>
                                                        <label for="" class="time-type" id="old-pickup-type" old-pickup-type="<?= "am" ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="administrative-section">
                                                <label class="administrative-header" for="">Departure time:</label>
                                                <div class="time-format-seperator">
                                                    <div class="update-delay-time" id="update-delay-time">
                                                        <div class="newly-time-clock">
                                                            <label class="new-time-matter" id="new-time-departure" new-time-departure="<?= "7" ?>" for=""></label>
                                                            <label class="new-format-matter" id="new-time-departureF" new-time-departureF="<?= "am" ?>"></label>
                                                        </div>
                                                        <div class="newly-updateT" id="departure-time-new"></div>
                                                    </div>
                                                    <div class="admin-time-format" id="admin-time-format">
                                                        <label class="administrative-pickup-timeT" id="old-departure-time" old-departure-time="<?= "5" ?>" for=""></label>
                                                        <label for="" class="time-type" id="old-departure-type" old-departure-type="<?= "pm" ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="administrative-section">
                                                <label class="administrative-header" for="">Arrival time:</label>
                                                <div class="time-format-seperator">
                                                    <div class="update-delay-time" id="update-delay-time">
                                                        <div class="newly-time-clock">
                                                            <label class="new-time-matter" id="new-time-arrival" new-time-arrival="<?= "8" ?>" for=""></label>
                                                            <div class="new-format-matter" id="new-time-arrivalF" new-time-arrivalF="<?= "pm" ?>"></div>
                                                        </div>
                                                        <div class="newly-updateT" id="arrival-time-new"></div>
                                                    </div>
                                                    <div class="admin-time-format" id="admin-time-format">
                                                        <label class="administrative-pickup-timeT" id="old-arrival-time" old-arrival-time="<?= "9:30" ?>" for=""></label>
                                                        <label for="" class="time-type" id="old-arrival-type" old-arrival-type="<?= "am" ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="administrative-section" id="administrative-section">
                                                <label class="administrative-header" for="">Shipment status:</label>
                                                <div class="time-format-seperator">
                                                    <div class="admin-shipping-status" id="admin-shipping-status">
                                                        <label for="" class="" id="shipment-status"></label>
                                                    </div>
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
            <div class="shipping-weather-container">
                <div class="weather-con1">
                    <div class="shipment-header-section">
                        <img class="header-weather-icon" src="../../../IMAGES/GENERAL/sender-weather.png" alt="">
                        <label class="shipping-statement" for="">Pickup weather</label>
                    </div>
                    <div class="weather-analysis-container" id="weather-analysis-container">
                        <div class="weather-analysis-header">
                            <div class="weather-warning-icon">
                                <img class="weather-analysis-img" src="../../../IMAGES/GENERAL/i-warning.png" alt="">
                            </div>
                            <div class="weather-header-notice">
                                Delay, prior to weather disturbances
                            </div>
                        </div>
                        <div class="weather-analysis-section">
                            <div class="weather-text-status" id="weather-text-status">
                                <?php
                                echo ' <label> ';
                                if ($transportation === 'Plane') {
                                    echo "Takeof and takeoff are restricted around <label class='restricted-country'>" . $pickup_country .  " </label> border, Your shipment is delayed please wait for further updates.";
                                } elseif ($transportation === 'Vessel') {
                                    echo "Departure and sailing are restricted around <label class='restricted-country'>" . $pickup_country .  " </label> border, Your shipment is delayed please wait for further updates.";
                                } elseif ($transportation === 'Inland') {
                                    echo "Trucking are restricted around <label class='restricted-country'>" . $pickup_country .  "</label> border, Your shipment is delayed please wait for further updates.";
                                }
                                '</label>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="weather-app-container">
                        <div class="weather-city" id="weather-city">City</div>
                        <div class="secon-weather">
                            <div class="majorData-section">
                                <div class="row-weather-dataCon">
                                    <div class="temperature-icon-valueCon">
                                        <img class="weather-icon" src="" alt="" id="weather-icon">
                                        <div class="temperature" id="temp">11</div>
                                    </div>
                                    <div class="weather-secon-data">
                                        <div class="weather-description" id="weather-description">Weather Description</div>
                                        <div class="min-max-temp" id="min-max-temp">min-max-temp</div>
                                        <div class="wind-directionSpeed" id="wind-direction">Wind direction and speed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="city-clock-con">
                                <div class="current-time" id="current-time">10:14pm</div>
                                <div class="current-date" id="current-date">Saturday, February 2, 2024</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="weather-con2">
                    <div class="shipment-header-section">
                        <img class="header-weather-icon" src="../../../IMAGES/GENERAL/recepient-weather.png" alt="">
                        <label class="shipping-statement" for="">Destination weather</label>
                    </div>
                    <div class="weather-analysis-container1" id="weather-analysis-container1">
                        <div class="weather-analysis-header">
                            <div class="weather-warning-icon">
                                <img class="weather-analysis-img" src="../../../IMAGES/GENERAL/i-warning.png" alt="">
                            </div>
                            <div class="weather-header-notice">
                                Delay, prior to weather disturbances
                            </div>
                        </div>
                        <div class="weather-analysis-section">
                            <div class="weather-text-status" id="weather-text-status">
                                <?php
                                echo ' <label> ';
                                if ($transportation === 'Plane') {
                                    echo "Departure and takeoff are restricted around <label class='restricted-country'>" . $delivery_country .  " </label> border, Your shipment is delayed please wait for further updates.";
                                } elseif ($transportation === 'Vessel') {
                                    echo "Departure and sailing are restricted around <label class='restricted-country'>" . $delivery_country .  " </label> border, Your shipment is delayed please wait for further updates.";
                                } elseif ($transportation === 'Inland') {
                                    echo "Due to weather disturbances <label class='restricted-country'>" . $delivery_country .  "</label> border, Your shipment is delayed please wait for further updates.";
                                }
                                '</label>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="weather-app-container">
                        <div class="weather-city" id="weather-city1">City</div>
                        <div class="secon-weather">
                            <div class="majorData-section">
                                <div class="row-weather-dataCon">
                                    <div class="temperature-icon-valueCon">
                                        <img class="weather-icon" src="" alt="" id="weather-icon1">
                                        <div class="temperature" id="temp1">11</div>
                                    </div>
                                    <div class="weather-secon-data">
                                        <div class="weather-description" id="weather-description1">Weather Description</div>
                                        <div class="min-max-temp" id="min-max-temp1">min-max-temp</div>
                                        <div class="wind-directionSpeed" id="wind-direction1">Wind direction and speed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="city-date-con">
                                <div class="city-clock-con">
                                    <div class="current-time" id="current-time1">10:14pm</div>
                                    <div class="current-date" id="current-date1">Saturday, February 2, 2024</div>
                                </div>
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
                            <label class="shipping-statement" for="">Official receipt</label>
                        </div>
                        <?= '<a href="../../../PHP-MODULES/USER/VIEW-SHIPMENT/edit-shipment.php?id= ' . $id .
                            '&declared_item=' . $declared_item .
                            '&shipping_id=' . $shipping_id .
                            '&shipment_price=' . $shipment_price .
                            '&shipping_code=' . $shipping_code .
                            '&declared_weight=' . $declared_weight .
                            '&pickup_id=' . $pickup_id .
                            '&pickup_country=' . $pickup_country .
                            '&pickup_address=' . $pickup_address .
                            '&pickup_date=' . $pickup_date .
                            '&package_type=' . $package_type .
                            '&delicate_type=' . $delicate_type .
                            '&delivery_id=' . $delivery_id .
                            '&delivery_country=' . $delivery_country .
                            '&delivery_address=' . $delivery_address .
                            '&arrival_date=' . $arrival_date .
                            '&transportation=' . $transportation .
                            ' " class="modification-container">
                    <p>Modify this shipment?</p>
                </a>' ?>
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
                            } ?>
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