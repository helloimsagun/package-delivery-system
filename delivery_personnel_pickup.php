<?php
$cssFiles = ['dashboard.css']; // Specify the CSS file names here dynamically as an array ['', '']
$disableBootstrap = true; // Disable Bootstrap CSS
$disableGoogleFonts1 = true; // Disable Google Fonts 1
include 'php/connection.php';
include 'php/page_header.php';
include 'php/dashboard_check.php';

include 'php/dashboard_main.php';
include 'php/modals.php';

$vendorFiles = ['jquery/jquery.min.js','jquery-easing/jquery.easing.min.js','bootstrap/js/bootstrap.bundle.min.js','datatables/jquery.dataTables.min.js','datatables/dataTables.bootstrap4.min.js']; // Specify the JavaScript file names here dynamically as an array ['', '']
$jsFiles = ['dashboard.js','success.js','datatables-demo.js','populateEditModal.js']; // Specify the JavaScript file names here dynamically as an array ['', '']
include 'php/page_footer.php';
?>

