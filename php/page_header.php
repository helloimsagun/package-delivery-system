<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <meta name="description"
        content="SwiftStreams Pvt Ltd is a leading logistics company specializing in transportation, warehousing, and delivery services. We provide reliable and efficient solutions for businesses across various industries. With our experienced team and advanced logistics infrastructure, we ensure timely and secure delivery of goods. Contact us for all your logistics needs." />
    <meta name="author" content="Rikesh Maharjan" />
    <!-- Icon -->
    <link rel="icon" type="image/svg+xml" href="images/logo.svg" />


    <?php if (isset($cssFiles) && is_array($cssFiles)): ?>
        <?php foreach ($cssFiles as $cssFile): ?>
            <link rel="stylesheet" href="styles/<?php echo $cssFile; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Font Awesome icons (free version)-->
    <script src="https://kit.fontawesome.com/1f6a832ce8.js" crossorigin="anonymous"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap css -->
    <?php if (!isset($disableBootstrap) || !$disableBootstrap): ?>
        <link rel="stylesheet" href="modules/node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <?php endif; ?>
    <!-- Google fonts-->
    <?php if (!isset($disableGoogleFonts1) || !$disableGoogleFonts1): ?>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <?php endif; ?>
    <?php if (isset($disableGoogleFonts1) || !$disableGoogleFonts1): ?>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <?php endif; ?>