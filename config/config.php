<?php

ob_start(); // Enables output buffering, which saves php data when page is loaded and sends data to page
session_start();

$timezone = date_default_timezone_set('America/Chicago');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect("localhost", "root", "", "social");

if (mysqli_connect_errno()) {
    echo "Failed to connect to database: " . mysqli_connect_errno();
}