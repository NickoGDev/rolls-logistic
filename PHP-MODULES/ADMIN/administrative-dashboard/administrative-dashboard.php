<?php
include "../../../PHP-MODULES/connection.php";
$query_count_of_admin = "SELECT COUNT(*) AS count from main_admin_account";
$result_count_of_admin = mysqli_query($con, $query_count_of_admin);

$admin_role_status = "";
if ($result_count_of_admin) {
    $row = mysqli_fetch_assoc($result_count_of_admin);
    $count_admin = $row['count'];

    if ($count_admin > 0) {
        $admin_role_status = "occupied";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrative dashboard</title>
    <link rel="stylesheet" href="../../../STYLES/OVERALL/overall.css">
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../STYLES/ADMIN/administrative-dashboard/administrative-dashboard.css">
</head>

<body>
    <div class="body-container">
        <div class="body-section">
            <div class="dashboard-header-container">
                <label class="dashboard-header">
                    Administrative Roles
                </label>
            </div>
            <div class="body-lot">
                <div class="dashboard-content">
                    <div class="dashboard-seperator">
                        <div class="left-section-relative">
                            <div class="admin-role-container" id="admin-role-container">
                                Role filled
                            </div>
                            <div class="left-section-dashboard" id="left-section-dashboard" left-section-occupation="<?= $admin_role_status ?>">
                                <div class="heading-container">
                                    <label class="card-header-p" for="">Main Admin</label>
                                </div>
                                <div class="dashboard-lot">
                                    <div class="card-seperator">
                                        <div class="img-guideT-container">
                                            <img class="admin-roles-img" src="../../../IMAGES/GENERAL/admin-roles.png" alt="">
                                            <div class="guideline-qualification">
                                                <label class="img-guideT" for="">Register or Login, gain administrative task and maintain the monitoring consistent work flow.</label>
                                                <div class="qualification-container">
                                                    <label class="qualification-heading" for="">Activities</label>
                                                    <ul class="list-qualification">
                                                        <li class="qualification">Monitor customer shipping state.</li>
                                                        <li class="qualification">Account review for Rolls member staff.</li>
                                                        <li class="qualification">Understand basic metrics for weathering system.</li>
                                                        <li class="qualification">Encoding client shipping details.</li>
                                                        <li class="qualification">Monitor staff attendance & movements.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="link-button-container">
                                            <a class="admin-register" href="../../ADMIN/Madmin-signup/admin-signup.php">Register</a>
                                            <a class="admin-login" href="../../ADMIN/Madmin-login/Madmin-login.html">Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section-seperator"></div>
                        <div class="right-section-dashboard">
                            <div class="heading-container">
                                <label class="card-header-p" for="">Staff members</label>
                            </div>
                            <div class="dashboard-lot">
                                <div class="card-seperator">
                                    <div class="img-guideT-container">
                                        <img class="admin-roles-img" src="../../../IMAGES/GENERAL/member-roles.png" alt="">
                                        <div class="guideline-qualification">
                                            <label class="img-guideT" for="">Register or Login, monitor shipping updates and queries around the world.</label>
                                            <div class="qualification-container">
                                                <label class="qualification-heading" for="">Activities</label>
                                                <ul class="list-qualification">
                                                    <li class="qualification">Monitor customer shipping state.</li>
                                                    <li class="qualification">Understand basic metrics for weathering system.</li>
                                                    <li class="qualification">Encoding client shipping details.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="link-button-container">
                                        <a class="admin-register" href="../../ADMIN/Smember-signup/Smember-signup.html">Register</a>
                                        <a class="admin-login" href="../../ADMIN/Smember-login/Smember-login.html">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../JAVASCRIPT/ADMIN/administrative-dashboard/administrative-dashboard.js"></script>
</body>

</html>