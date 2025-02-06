<?php
include "PHP-MODULES/connection.php";
session_start();
if (isset($_POST['track-button'])) {
    $shipping_code = $_POST['track-code'];

    $track_sql = "SELECT * FROM user_shippings WHERE BINARY shipping_code ='$shipping_code' ";
    $track_result = mysqli_query($con, $track_sql);

    if (mysqli_num_rows($track_result) > 0) {

        $shipment_details_sql = " SELECT
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
        user_shippings.shipping_code = '$shipping_code'
    
    ";
        $shipment_details_result = mysqli_query($con, $shipment_details_sql);

        $booking_info = "";
        if ($shipment_details_result) {
            $shipment_details = [];
            while ($row = mysqli_fetch_assoc($shipment_details_result)) {
                $shipping_code = $row['shipping_code'];
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

                $pickup_country = $row['pickup_country'];

                $delivery_id = $row['delivery_id'];
                $delivery_country = $row['delivery_country'];
                $delivery_address = $row['delivery_address'];
                $arrival_date = date('m/d/Y', strtotime($row['arrival_date']));
                $transportation = $row['transportation'];

                $shipment_details[] = [
                    'shipping_code' => $shipping_code,
                    'id' => $id,
                    'pickup_id' => $pickup_id,
                    'pickup_date' => $pickup_date,
                    'pickup_address' => $pickup_address,
                    'shipping_id' => $shipping_id,
                    'declared_items' => $declared_item,
                    'declared_weight' => $declared_weight,
                    'delicate_type' => $delicate_type,
                    'package_type' => $package_type,
                    'shipment_price' => $shipment_price,
                    'pickup_country' => $pickup_country,
                    'delivery_id' => $delivery_id,
                    'delivery_country' => $delivery_country,
                    'delivery_address' => $delivery_address,
                    'arrival_date' => $arrival_date,
                    'transportation' => $transportation,
                ];
                $_SESSION['shipment_details'] = $shipment_details;
            }
            header("location: PHP-MODULES/PORTAL-PAGES/VIEW-YOUR-SHIPMENT/view-your-shipment.php?shipping_code=" . $shipping_code . "&id=" . $id . "&pickup_id=" . $pickup_id . "&pickup_date=" . $pickup_date . "&pickup_address=" . $pickup_address . "&shipping_id=" . $shipping_id . "&declared_items=" . $declared_item . "&declared_weight=" . $declared_weight . "&delicate_type=" . $delicate_type . "&package_type=" . $package_type . "&shipment_price=" . $shipment_price . "&pickup_country=" . $pickup_country . "&delivery_id=" . $delivery_id . "&delivery_country=" . $delivery_country . "&delivery_address=" . $delivery_address . "&arrival_date=" . $arrival_date . "&transportation=" . $transportation . "");
        }
    } else {
        header("location: PHP-MODULES/PORTAL-PAGES/VIEW-YOUR-SHIPMENT/view-your-shipment.php?shipping_code=");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--Font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font awesome link-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!--CSS links-->
    <link rel="stylesheet" href="STYLES/OVERALL/overall.css">
    <link rel="stylesheet" href="STYLES/OVERALL/header.css">
    <link rel="stylesheet" href="STYLES/PORTAL-PAGE/portal-page.css">
    <link rel="stylesheet" href="STYLES/FOOTER/footer.css">

    <!-- CSS components -->
    <link rel="stylesheet" href="STYLES/STYLES-COMPONENTS/heading.css">
    <link rel="stylesheet" href="STYLES/STYLES-COMPONENTS/card-grids3.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rolls Logistics</title>
</head>

<body>
    <!-- HEADER-CONTAINER -->
    <div class="header-container">
        <div class="header-sections">
            <div class="header-components">
                <div class="header-left-section">
                    <div class="logo-font">
                        <label for="">Rolls Logistics</label>
                    </div>
                    <div class="header-services">
                        <div class="services-navigation">
                            <a href="services.php">Services</a>
                        </div>
                    </div>
                </div>
                <div class="header-right-section">
                    <div class="services-navigation">
                        <a class="login-now" href="login.php">Login Now!</a>
                        <a class="register-now" href="signup.php">Create an account</a>
                    </div>
                </div>
            </div>
            <div class="header-campaign-headings">
                <div class="campaign-title">Revolutionize and transform your business flow</div>
            </div>
        </div>
    </div>
    <div class="campaign-section">
        <img src="IMAGES/GENERAL/pic.jpg" alt="">
        <!-- <div class="header-center-headings">
            <div class="tracking-header">
                Shipping code
            </div>
            <form method="POST" class="tracking-input">
                <div class="overlay-location">
                    <input type="text" name="track-code" placeholder="Enter shipment code" required>
                    <div class="location-logo"><img src="IMAGES/GENERAL/location.png" alt=""></div>
                </div>
                <div class="tracking-button-container">
                    <button type="submit" name="track-button">Track code</button>
                </div>
            </form>
        </div> -->
    </div>
    <div class="body-container">
        <div class="body-section">
            <div class="body-account">
                <div class="body-account-textguide">
                    <div class="account-sections">
                        <div class="account-lot">
                            <div class="body-account-icon">
                                <img src="IMAGES/GENERAL/global.png" alt="">
                            </div>
                            <div class="account-texts">
                                <div class="body-account-header">How to get started</div>
                                <div class="body-account-subheader">
                                    <label for="">Step by step guides to get started using our digital services. </label>
                                    <div class="register-container">
                                        <a href="signup.php" class="register-button">Learn more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="account-sections">
                        <div class="account-lot">
                            <div class="body-account-icon">
                                <img src="IMAGES/GENERAL/add-user.png" alt="">
                            </div>
                            <div class="account-texts">
                                <div class="body-account-header">New to Rolls.com?</div>
                                <div class="body-account-subheader">
                                    <label for="">Sign up to book online, manage and pay for shipments, and access a suite of products and services designed to simplify your supply chain. </label>
                                    <div class="register-container">
                                        <a href="signup.php" class="register-button">Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shipments-heading-components -->
            <div class="shipments-heading-components">
                <label class="shipments-headerP" for="">Shipment solutions</label>
                <div class="shipments-secondaryS">
                    From the farm to your fridge, or the warehouse to your wardrobe, Rolls is developing solutions that meet customer needs from one end of the supply chain to the other.
                </div>
                <div class="shipments-button-link">
                    <a href="" for="">See all solutions</a>
                </div>
            </div>
            <!-- CARD-GRID -->
            <div class="card-grid">
                <div class="card-grid-section">
                    <a href="services.php" class="card-grid-contents">
                        <img src="IMAGES/GENERAL/PORTAL-PAGES/inland-image.jpg" alt="">
                        <div class="card-grid-row">
                            <div class="card-grid-textH">
                                Transport Services
                            </div>
                            <div class="card-grid-textS">
                                Learn how Rolls offers small and large businesses the opportunity to grow.
                            </div>
                        </div>
                    </a>
                    <div class="card-grid-contents">
                        <img src="IMAGES/GENERAL/PORTAL-PAGES/supply-chain.webp" alt="">
                        <div class="card-grid-row">
                            <div class="card-grid-textH">
                                Supply Chain and Logistics
                            </div>
                            <div class="card-grid-textS">
                                We focus on solving your supply chain needs from end to end, taking the complexity out of container shipping for you.
                            </div>
                        </div>
                    </div>
                    <div class="card-grid-contents">
                        <img src="IMAGES/GENERAL/PORTAL-PAGES/digital-solution.webp" alt="">
                        <div class="card-grid-row">
                            <div class="card-grid-textH">
                                Digital Solutions
                            </div>
                            <div class="card-grid-textS">
                                Our tailored online services take the complexity out of shipping by letting you instantly book, manage and track shipments, submit Verified Gross Mass information and much more.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- equal-horizontalE -->

        </div>
    </div>
    <?= include "PHP-MODULES/FILE-COMPONENTS/footer.html" ?>
    <script src="JAVASCRIPT/PORTAL-PAGE/portal-page.js"></script>
</body>

</html>