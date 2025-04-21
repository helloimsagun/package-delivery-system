<?php
$cssFiles = ['index.css', 'card.css']; // Specify the CSS file names here dynamically as an array ['', '']
$disableBootstrap = true; // Disable Bootstrap CSS
$disableGoogleFonts1 = false; // Enable Google Fonts 1

include 'php/connection.php';
include 'php/page_header.php';

include 'php/index_main.php';

$vendorFiles = ['jquery/jquery.min.js','jquery-easing/jquery.easing.min.js','bootstrap/js/bootstrap.bundle.min.js']; // Specify the JavaScript file names here dynamically as an array ['', '']
$jsFiles = ['index.js', 'card.js', 'validateRegister.js']; // Specify the JavaScript file names here dynamically as an array ['', '']
include 'php/main_footer.php';
include 'php/page_footer.php';
?>