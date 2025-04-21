<title>Home Page</title>

</head>

<body id="page-top">
    <?php include 'php/navbar.php'; ?>
    <!-- Masthead-->
    <header class="masthead" id="home">
        <div class="container">
            <div class="masthead-subheading">Providing Fast and effortlessly convenient deliveries, every time.</div>
            <div class="masthead-heading text-uppercase">SwiftStreams Pvt Ltd</div>
            <a class="btn btn-primary btn-xl text-uppercase" data-bs-toggle="modal"
                data-bs-target="#checkStatusModal">Check Packages</a>
        </div>
    </header>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Services</h2>
                <h3 class="section-subheading text-muted"></h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-truck-fast fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Express Delivery</h4>
                    <p class="text-muted">Our company ensure your package reaches its destination swiftly with our guaranteed fast delivery service..
                    </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Package Security</h4>
                    <p class="text-muted">Rest easy knowing your items are protected during transit with our secure handling services</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-clock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Real-Time Tracking</h4>
                    <p class="text-muted">Monitor your package every step of the way with our live tracking feature, giving you full transparency.</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-boxes-stacked fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Bulk Package Discounts</h4>
                    <p class="text-muted">Send multiple packages at a reduced rate with our special bulk shipping options, perfect for businesses.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-wine-glass fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Fragile Item Handling</h4>
                    <p class="text-muted">Our team takes extra care with delicate items, providing specialized packaging and careful handling to prevent damage.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-road-circle-check fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Last Mile Delivery</h4>
                    <p class="text-muted">This service ensures that products are delivered to customers' doorsteps in a
                        timely and efficient manner.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- About-->
    <section class="page-section" id="about">
        <div class="container">
            <div class="text-center">
            <img src="images/logo.svg"
                    width="200" height="200" style="border:0"
                    ></img>
                <h2 class="section-heading text-uppercase">About</h2>
                <h3 class="section-subheading text-muted">Your Trusted Partner for Timely and Secure Deliveries</h3>
            </div>
            <center>
            <p><b>Welcome to SwiftStreams Pvt Ltd</b><br>
Founded in 2024, SwiftStreams Pvt Ltd is revolutionizing the package delivery industry with our commitment to reliability, efficiency, and innovation. We are dedicated to transforming how businesses and individuals experience package delivery by offering solutions that ensure every package reaches its destination safely and on time.
</p><p>
<b>Our Commitment</b><br>
At SwiftStreams, our goal is to deliver more than just packages—we deliver peace of mind. With a team of seasoned professionals and cutting-edge technology, we guarantee excellence in every aspect of our service, making us a trusted partner for all your delivery needs.
</p>
<b>Building Lasting Relationships</b><br>
We believe in the power of strong, long-lasting relationships with our clients. Our unwavering dedication to customer satisfaction is the foundation of our success and the driving force behind our continued innovation in the package delivery industry.</p>
            </center>
        </div>
    </section>

    <!-- Check Status Modal -->
    <div class="modal fade" id="checkStatusModal" tabindex="-1" aria-labelledby="checkStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary-to-secondary p-4">
                    <h5 class="modal-title font-alt text-black" id="checkStatusModalLabel">Check Package Status</h5>
                    <button class="btn-close btn-close-black" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body border-0 p-4">
                    <form id="checkStatusForm" method="POST" action="check_package_page.php">
                        <!-- Order Code input -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="orderCode" name="orderCode" type="text"
                                placeholder="Enter order code..." required />
                            <label for="orderCode">Order Code</label>
                        </div>
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button class="btn btn-primary rounded-pill btn-lg" type="submit">Check Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    