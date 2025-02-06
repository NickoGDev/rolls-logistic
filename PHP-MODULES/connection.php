<?php

$LOCALHOST = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DBNAME = "logistic";

$con = new mysqli($LOCALHOST, $USERNAME, $PASSWORD, $DBNAME);

if (!$con) {
    die("Connection error: " . $con->connect_error);
}
