<?php

include '../../connection.php';

$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
// (1) TBL user_shippings
// Choose latest row
$sql_view_book = "
SELECT 
    user_shippings.declared_items, 
    user_shippings.declared_weight, 
    user_shippings.delicate_type, 
    user_shippings.package_type,
    user_shippings.shipment_price,

    pickup_countries.pickup_country,
    pickup_countries.transportation, 
    pickup_countries.pickup_address,
    pickup_countries.transportation,
    pickup_countries.pickup_date,

    delivery_countries.delivery_country,
    delivery_countries.delivery_address,
    delivery_countries.arrival_date

FROM 
    user_shippings
LEFT JOIN 
    pickup_countries ON user_shippings.shipping_id = pickup_countries.pickup_id

LEFT JOIN 
    delivery_countries ON user_shippings.shipping_id = delivery_countries.delivery_id

WHERE 
    user_shippings.shipping_id = delivery_countries.delivery_id
ORDER BY 
    user_shippings.shipping_id DESC
LIMIT 1";

$result_view_book = mysqli_query($con, $sql_view_book);


if ($result_view_book) {
    while ($row = mysqli_fetch_assoc($result_view_book)) {


        $declared_item = $row['declared_items'];
        $declared_weight = $row['declared_weight'];
        $delicate_type = $row['delicate_type'];
        $package_type = $row['package_type'];
        $shipment_price = $row['shipment_price'];

        $pickup_country = $row['pickup_country'];
        $transportation = $row['transportation'];
        $pickup_address = $row['pickup_address'];
        $pickup_date = date('m/d/Y', strtoTime($row['pickup_date']));

        $delivery_country = $row['delivery_country'];
        $delivery_address = $row['delivery_address'];
        $arrival_date = date('m/d/Y', strtoTime($row['arrival_date']));

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
            <label for="" class="cargo-item">' . $pickup_date . '</label>
            <label for="" class="delicate-state-year">mm/dd/yyyy</label>
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
            <label for="" class="cargo-item">' . $arrival_date . ' </label>
            <label for="" class="delicate-state-year">mm/dd/yyyy</label>
        </div>
    </div>
</div>
</div>
    
        ';

        $pricing_info = '
    <div class="mode-transpo">
        <div class="transpo-container">
            <label class="transpo-header" for="">Mode of Transportation</label>
            <div class="transpo-section">
                <img src="';

        if ($transportation == 'Plane') {
            $pricing_info .= '../../../IMAGES/GENERAL/transport/plane.png';
        } elseif ($transportation == 'Vessel') {
            $pricing_info .= '../../../IMAGES/GENERAL/transport/vessel.png';
        } elseif ($transportation == 'Inland') {
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
    }
} else {
    echo "View failed";
}

if (isset($_POST['done-btn'])) {
    header('location: ../../../PHP-MODULES/USER/MY-BOOKING/my-booking.php?id=' . $id . '');
}

// $iv = substr('your_iv_here12345', 0, 16);

// Encrypt the $id before passing it in the URL
// $encrypted_id = openssl_encrypt($id, 'aes-256-cbc', 'your_secret_key', 0, $iv);

// if (isset($_POST['done-btn'])) {
//     header('location: ../../../PHP-MODULES/USER/MY-BOOKING/my-booking.php?id=' . urlencode($encrypted_id));
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        // AVOID FORM RESUBMISSION
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <!--Font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--CSS links-->
    <link rel="stylesheet" href="../../../STYLES/OVERALL/overall.css">
    <link rel="stylesheet" href="../../../STYLES/USER/HEADER/header.css">
    <link rel='stylesheet' href="../../../STYLES/USER/SHIPMENT-FORM/confirm-booking.css">
</head>

<body>
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
    <div class="feed-section">
        <!-- PROCESS-SECTION -->
        <div class="process-section">
            <div class="process-header">
                <label for="">View-Cargo</label>
            </div>
            <div class="process-progress-container">
                <div class="current-progress">
                    <div class="progress-circle-label">
                        <img class="sign" src="../../../IMAGES/GENERAL/proceeding-progress.png" alt="">
                        <label class="untraversed-process" for="">Information</label>
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
                        <img class="sign" src="../../../IMAGES/GENERAL/logo.png" alt="">
                        <label for="">Booked</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- BODY-CONTAINER -->
        <div class="body-container">
            <div class="body-section">
                <div class="body-confirm-seperator">
                    <div class="body-contents">
                        <div class="booking-header">
                            <label for="">Shipment Information</label>
                        </div>
                        <div class="booked-information">
                            <?php echo  $booking_info ?>
                        </div>
                    </div>
                    <div class="pricing-modeTranspo">
                        <div class="booking-header">
                            Transportation & Pricing
                        </div>
                        <?= $pricing_info  ?>
                        <div class="transpo-divider">
                            <hr>
                        </div>
                        <?= $total_price; ?>
                    </div>
                </div>
                <form method="post" class="done-btn" class="view-booking">
                    <button name="done-btn">My booking's</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../JAVASCRIPT/USER/CONFIRM-BOOKING/confirm-booking.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>