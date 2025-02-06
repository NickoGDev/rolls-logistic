<?php
include "../../connection.php";
$id = $_GET['id'];

$shipping_id = $_GET['shipping_id'];
$shipment_price = $_GET['shipment_price'];
$shipping_code = $_GET['shipping_code'];
$declared_item =  $_GET['declared_item'];
$declared_weight = $_GET['declared_weight'];
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

$formatted_pickup_date = date('Y-m-d', strtotime($pickup_date));
$formatted_arrival_date = date('Y-m-d', strtotime($arrival_date));

// SELECT COUNTRIES
$query_countries = "SELECT countries FROM route_countries";
$result_country = mysqli_query($con, $query_countries);
$all_countries = '';
if ($result_country) {
    while ($row = mysqli_fetch_assoc($result_country)) {
        $all_countries .= '<option>' . $row['countries'] . '</option>';
    }
} else {
    echo "<script>alert('Error in query: " . mysqli_error($con) . "')</script>";
}





if (isset($_POST['submit-book'])) {

    // INSERT SHIPPING ITEM MATTER
    $declared_item = $_POST['declared-items'];
    $declared_weight = $_POST['declared-weight'];
    $declared_delicate = $_POST['declared-delicate'];
    $declared_package = $_POST['declared-package'];
    $shipment_price = $_POST['shipment-price'];

    $sql_item_info = "UPDATE user_shippings SET 
                    declared_items = '$declared_item',
                    declared_weight = $declared_weight,
                    delicate_type = '$declared_delicate', 
                    package_type =  '$declared_package', 
                    user_id = '$id', 
                    shipment_price = $shipment_price
                    WHERE shipping_id = $shipping_id";
    $result_booking = mysqli_query($con, $sql_item_info);

    // INSERT PICKUP_COUNTRY MATTER
    $pickup_date = $_POST['pickup-date'];
    $pickup_country = $_POST['pickup-country'];
    $pickup_address = $_POST['pickup-address'];
    $mode_transportation = $_POST['mode-transportation'];

    $sql_pickup_country = "UPDATE pickup_countries SET 
                                                       pickup_country = '$pickup_country', 
                                                       pickup_address = '$pickup_address',
                                                       pickup_date =  '$pickup_date', 
                                                       transportation = '$mode_transportation',
                                                       user_id = '$id' 
                                                       WHERE pickup_id = $pickup_id";
    $result_pickup_country = mysqli_query($con, $sql_pickup_country);

    // INSERT DELIVERY_COUNTRY  MATTER
    $delivery_country = $_POST['delivery-country'];
    $delivery_address = $_POST['delivery-address'];
    $arrival_date = $_POST['arrival-date'];

    $sql_delivery_country = "UPDATE delivery_countries SET
                             delivery_country = '$delivery_country',
                             delivery_address = '$delivery_address',
                             arrival_date = '$arrival_date', user_id = '$id'
                             WHERE delivery_id = $delivery_id";
    $result_delivery_country = mysqli_query($con, $sql_delivery_country);


    if (!$result_booking || !$result_pickup_country || !$result_delivery_country) {
        echo "Insert error";
    } else {
        header("Location: ../../../PHP-MODULES/USER/VIEW-SHIPMENT/view-shipment.php?id=$id" .
            "&declared_item=$declared_item" .
            "&shipping_id=$shipping_id" .
            "&shipment_price=$shipment_price" .
            "&shipping_code=" . $shipping_code .
            "&declared_weight=$declared_weight" .
            "&pickup_id=$pickup_id" .
            "&pickup_country=$pickup_country" .
            "&pickup_address=$pickup_address" .
            "&pickup_date=$pickup_date" .
            "&package_type=$package_type" .
            "&delicate_type=$delicate_type" .
            "&delivery_id=$delivery_id" .
            "&delivery_country=$delivery_country" .
            "&delivery_address=$delivery_address" .
            "&arrival_date=$arrival_date" .
            "&transportation=$mode_transportation");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="../../../STYLES/OVERALL/overall.css">
    <link rel="stylesheet" href="../../../STYLES/USER/HEADER/header.css">
    <link rel="stylesheet" href="../../../STYLES/USER/VIEW-SHIPMENT/view-shipment.css">
    <link rel="stylesheet" href="../../../STYLES/USER/SHIPMENT-FORM/shipment-form.css">

    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shipment</title>
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
                    <div class="header-services">
                        <div class="services-navigation">
                            <?= '<a href="../../../PHP-MODULES/USER/SHIPMENT-FORM/shipment-form.php?id=' . $id . '">Shipment form</a>'; ?>
                            <?= '<a href="../../../PHP-MODULES/USER/MY-BOOKING/my-booking.php?id=' . $id . '">My booking</a>'; ?>
                        </div>
                    </div>
                </div>
                <div class="header-right-section">
                    <div class="personalization-container">
                        <img src="../../../IMAGES/GENERAL/account.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--BODY-CONTAINER-->
    <div class="body-container">
        <form method="POST" class="body-section" id="booking-form" name="booking-form">
            <div class="process-container">
                <div class="process-section">
                    <div class="process-header">
                        <label for="">Edit-cargo</label>
                    </div>
                    <div class="process-progress-container">
                        <div class="current-progress">
                            <div class="progress-circle-label">
                                <img class="sign" src="../../../IMAGES/GENERAL/logo.png" alt="">
                                <label for="">Information</label>
                            </div>
                            <div class="current-hr">
                                <hr>
                            </div>
                        </div>
                        <div class="current-progress">
                            <div class="current-hr">
                                <hr>
                            </div>
                            <div class="progress-circle-label">
                                <img class="sign" src="../../../IMAGES/GENERAL/proceeding-progress.png" alt="">
                                <label class="untraversed-process" for="">Booked</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STEPS-CONTAINER -->
            <div class="steps-container">
                <div class="steps-section">
                    <div class="steps-header">
                        Cargo Details
                    </div>
                    <div class="numerical-steps">
                        <p>1.</p>
                        <label for="">Item & Packaging</label>
                        <hr>
                        <div class="tooltip-form">
                            <img src="../../../IMAGES/GENERAL/info.png" alt="">
                            <div class="tooltip-form-guide">
                                <label for="">Declaration of shipment items.</label>
                                <div class="tooltip-instruction">
                                    Input your shipment cargo and way of packaging.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- SHIPPING-FORM -->
            <div class="shipping-form">
                <div class="shipping-section">
                    <div class="shipment-form">
                        <div class="shipment-seperator-row">
                            <div class="shipment-fields">
                                <label for="declared-items">Declared items:</label>
                                <input type="text" id="declared-items" value="<?= $declared_item ?>" name="declared-items" min="20" placeholder="Commodity">
                                <div class="error-message" id="error-declared-items"></div>
                            </div>
                            <div class="shipment-fields">
                                <label for="">Package type:</label>
                                <select id="declared-package" name="declared-package">
                                    <option disabled style="display: none;">Choose package:</option>
                                    <option value="Cardboard boxes" <?= ($package_type == 'Cardboard boxes') ? 'selected' : '' ?>>Cardboard Boxes</option>
                                    <option value="Pallets" <?= ($package_type == 'Pallets') ? 'selected' : '' ?>>Pallets</option>
                                    <option value="Crates" <?= ($package_type == 'Crates') ? 'selected' : '' ?>>Crates</option>
                                    <option value="Bags/Sacks" <?= ($package_type == 'Bags/Sacks') ? 'selected' : '' ?>>Bags/Sacks</option>
                                    <option value="Tubes" <?= ($package_type == 'Tubes') ? 'selected' : '' ?>>Tubes</option>
                                    <option value="Refrigerated Containers" <?= ($package_type == 'Refrigerated Containers') ? 'selected' : '' ?>>Refrigerated Containers</option>
                                    <option value="Flexible Packaging" <?= ($package_type == 'Flexible Packaging') ? 'selected' : '' ?>>Flexible Packaging</option>
                                    <option value="Plastic Containers" <?= ($package_type == 'Plastic Containers') ? 'selected' : '' ?>>Plastic Containers</option>
                                </select>
                                <div class="error-message" id="error-declared-package"></div>
                            </div>

                        </div>
                        <!-- <div class="shipment-seperator-row">
                            
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- STEPS-CONTAINER -->
            <div class="steps-container">
                <div class="steps-section">
                    <div class="steps-header">
                        Calculate & Metrics
                    </div>
                    <div class="numerical-steps">
                        <p>2.</p>
                        <label for="">Weight Calculator</label>
                        <hr>
                        <div class="tooltip-form">
                            <img src="../../../IMAGES/GENERAL/info.png" alt="">
                            <div class="tooltip-form-guide">
                                <label for="">Cargo weight declaring</label>
                                <div class="tooltip-instruction">
                                    Calculate your gross weight shipment, using our gross weight calculator!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SHIPPING-FORM -->
            <div class="shipping-form">
                <div class="shipping-section">
                    <div class="shipment-form">
                        <div id="calculator-container">
                            <div class="calculate-header">
                                <label class="modal-title">Calculate Weight</label>
                                <div class="label-info">
                                    <div class="calculate-tooltip">
                                        <div class="tooltip-form">
                                            <img src="../../../IMAGES/GENERAL/info.png" alt="">
                                        </div>
                                        <div class="tooltip-guide">
                                            <label for="">Delicate Price:</label>
                                            <p><label for="">Delicate (Sturdy):</label> 45 peso x kg. </p>
                                            <p><label for="">Delicate (Fragile)</label> 62 peso x kg.</p>
                                            <br>
                                            <label for="">Transportation Price:</label>
                                            <p><label for="">Inland (Price)</label> 250 peso per shipment. </p>
                                            <p><label for="">Vessel (Price)</label> 500 peso per shipment. </p>
                                            <p><label for="">Plane (Price)</label> 750 peso per shipment. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-lot">
                                <div class="form-container">
                                    <div class="form-seperator">
                                        <div class="form-seperator-section">
                                            <div class="form-group">
                                                <label for="name" class="">Declared weight:</label>
                                                <div class="overlay-input">
                                                    <input type="text" class="" id="item-weight" value="<?= $declared_weight ?>" name="declared-weight" min="1" placeholder="Weight in kg" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                                                    <div class="absolute-guide">kg</div>
                                                </div>
                                                <div class="error-message" id="error-declared-weight"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Delicate type:</label>
                                                <select class="delicate-select" id="declared-delicate" name="declared-delicate">
                                                    <option class="disable-select" disabled style="display: none;">Choose Delicate</option>
                                                    <option value="Fragile" <?= ($delicate_type == 'Fragile') ? 'selected' : '' ?>>Fragile</option>
                                                    <option value="Sturdy" <?= ($delicate_type == 'Sturdy') ? 'selected' : '' ?>>Sturdy</option>
                                                </select>
                                                <div class="error-message" id="error-declared-delicate"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Mode of Transpo:</label>
                                                <select class="delicate-select" id="mode-transpo" name="mode-transportation">
                                                    <option disabled selected style="display: none;">Transport</option>
                                                    <option value="Inland" <?= ($transportation == 'Inland') ? 'selected' : '' ?>>Inland</option>
                                                    <option value="Vessel" <?= ($transportation == 'Vessel') ? 'selected' : '' ?>>Vessel</option>
                                                    <option value="Plane" <?= ($transportation == 'Plane') ? 'selected' : '' ?>>Plane</option>
                                                </select>
                                                <div class="error-message" id="error-mode-transpo"></div>
                                            </div>
                                        </div>
                                        <div class="calculate-result">
                                            <label for="">Total Price:</label>
                                            <label for="" id="display-full-price"><?= $shipment_price ?></label>
                                        </div>
                                        <div class="calculate-submit" id="calculate-submit-container">
                                            <button class="weight-calculator-trigger" id="calculate-button" type="button">
                                                Calculate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STEPS-CONTAINER -->
            <div class="steps-container">
                <div class="steps-section">
                    <div class="steps-header">
                        Sender & Recipient
                    </div>
                    <div class="numerical-steps">
                        <p>3.</p>
                        <label for="">Point to destination</label>
                        <hr>
                        <div class="tooltip-form">
                            <img src="../../../IMAGES/GENERAL/info.png" alt="">
                            <div class="tooltip-form-guide">
                                <label for="">Transaction flows.</label>
                                <div class="tooltip-instruction">
                                    Declare your pickup point and receiving point.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- SHIPPING-FORM -->
            <div class="shipping-form">
                <div class="shipping-section">
                    <div action="" class="shipment-form">
                        <div class="shipment-seperator-row">
                            <div class="shipment-fields">
                                <label for="">Pickup country:</label>
                                <select id="pickup-country" name="pickup-country">
                                    <option disabled style="display: none;">Pickup Countries</option>
                                    <option value="<?= $pickup_country ?>" <?= ($pickup_country !== null) ? 'selected' : '' ?>> <?= $pickup_country ?></option>
                                    <?php echo $all_countries; ?>
                                </select>
                                <div class=" error-message" id="error-pickup-country">
                                </div>
                            </div>
                            <div class="shipment-fields">
                            </div>
                        </div>
                        <div class="shipment-seperator-row">
                            <div class="shipment-fields">
                                <label for="">Pickup address:</label>
                                <input type="text" id="pickup-address" placeholder="Pickup address" name="pickup-address" value="<?= $pickup_address ?>">
                                <div class="error-message" id="error-pickup-address"></div>
                            </div>
                        </div>

                        <div class="shipment-seperator-row">
                            <div class="shipment-fields">
                                <label for="">Delivery country:</label>
                                <select id="delivery-country" name="delivery-country">
                                    <option disabled style="display: none;">Countries</option>
                                    <option value="<?= $delivery_country ?>" <?= ($delivery_country !== null) ? 'selected' : '' ?>> <?= $delivery_country ?> </option>
                                    <?= $all_countries ?>
                                </select>
                                <div class="error-message" id="error-delivery-country"></div>
                            </div>
                            <div class="shipment-fields">

                            </div>
                        </div>
                        <div class="shipment-seperator-row">
                            <div class="shipment-fields">
                                <label for="">Delivery address:</label>
                                <input type="text" id="delivery-address" placeholder="Delivery address" name="delivery-address" value="<?= $delivery_address ?>">
                                <div class=" error-message" id="error-delivery-address">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STEPS-CONTAINER -->
            <div class="steps-container">
                <div class="steps-section">
                    <div class="steps-header">
                        Date
                    </div>
                    <div class="numerical-steps">
                        <p>4.</p>
                        <label for="">Departure & Arrival</label>
                        <hr>
                        <div class="tooltip-form">
                            <img src="../../../IMAGES/GENERAL/info.png" alt="">
                            <div class="tooltip-form-guide">
                                <label for="">Setting up the Pickup date & Receiving data</label>
                                <div class="tooltip-instruction">
                                    Mark up the calendar with your pickup and arrival date.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="shipping-form">
                <div class="shipping-section">
                    <div action="" class="shipment-form">
                        <div class="shipment-seperator-row">
                            <div class="shipment-fields">
                                <label for="">Pickup date:</label>
                                <input type="date" id="declared-pickup" name="pickup-date" value="<?= $formatted_pickup_date ?>">
                                <div class=" error-message" id="error-declared-pickup">
                                </div>
                            </div>
                            <div class="shipment-fields">
                                <label for="">Arrival date:</label>
                                <input type="date" id="declared-arrival" name="arrival-date" value="<?= $formatted_arrival_date ?>">
                                <div class="error-message" id="error-declared-arrival"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STEPS-CONTAINER -->
            <div class="steps-container">
                <div class="steps-section">
                    <div class="steps-header">
                        Pricing
                    </div>
                    <div class="numerical-steps">
                        <p>5.</p>
                        <label for="">Gross Weight Price: </label>
                        <hr>
                        <div class="tooltip-form">
                            <img src="../../../IMAGES/GENERAL/info.png" alt="">
                            <div class="tooltip-form-guide">
                                <label for="">This is the total price, you need to pay</label>
                                <div class="tooltip-instruction">
                                    Have a second thought? use our weight calculator above this page!
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="shipping-form">
                <div class="shipping-section">
                    <div class="price-dashboard">
                        <label class="price-header" for="price-header">Total Price: </label>
                        <label class="display-full-price1" for="shipment-price" id="display-full-price1"><?= $shipment_price ?></label>
                        <!-- INVISIBLE INPUT associated at name: submit-book -->
                    </div>
                </div>
            </div>
            <div class="book-buttonContainer">
                <button type="submit" id="submit-book" name="submit-book">Book now</button>
                <input type="text" id="shipment-price1" name="shipment-price" value="<?= $shipment_price ?>" style="opacity: 0;">
            </div>
        </form>
    </div>

    <!-- Modal
    <div class="modal fade" id="okModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex flex-column align-items-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Booking</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div> -->
</body>
<script src="../../../JAVASCRIPT/USER/SHIPMENT-FORM/index.js"></script>

</html>