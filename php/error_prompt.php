<title>Error Occurred</title>

</head>

<body id="page-top">
    <?php include 'php/navbar.php'; ?>
    <!-- Masthead-->
    <header class="masthead" id="home">
        <div class="container">
        <div class="masthead-heading text-uppercase"><div class="alert alert-danger" role="alert">Error Occurred</div></div>

            <div class="masthead-subheading">
                <?php
                // Check if an error message is present in the URL
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    // Display the error message
                    echo htmlspecialchars($error);
                }
                ?>
            </div>
        </div>
    </header>