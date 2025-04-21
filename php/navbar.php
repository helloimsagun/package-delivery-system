<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php#page-top"><img src="images/logo.svg" alt="Logo" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
                <?php
                // Check if session is set
                if (isset($_SESSION['account_id'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>';
                    echo '<a href="php/logout.php"><button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0">
                        <span class="d-flex justify-content-center">
                            <i class="fa-regular fa-circle-user me-2"></i>
                            <span class="small">Logout</span>
                        </span>
                    </button></a>';
                } else {
                    echo '<button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal"
                        data-bs-target="#LoginRegisterModal">
                        <span class="d-flex justify-content-center">
                            <i class="fa-regular fa-circle-user me-2"></i>
                            <span class="small">Login</span>
                        </span>
                    </button>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="LoginRegisterModal" tabindex="-1" aria-labelledby="LoginRegisterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary-to-secondary p-4">
                <h5 class="modal-title font-alt text-black" id="LoginRegisterModalLabel">Login</h5>
                <button class="btn-close btn-close-black" type="button" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body border-0 p-4">
                <div class="card border-0" id="card">
                    <div class="card-front">
                        <!-- Login Form -->
                        <form id="loginForm" action="php/login.php" method="POST">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="loginEmail" name="loginEmail" type="email"
                                    placeholder="name@example.com" required>
                                <label for="loginEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="loginPassword" name="loginPassword" type="password"
                                    placeholder="Password" required>
                                <label for="loginPassword">Password</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary rounded-pill btn-lg" type="submit">Login</button>
                            </div>
                        </form>
                        <p class="mt-3">Don't have an account? <button class="btn btn-link btn-sm"
                                id="flipButtonFront">Register</button></p>
                    </div>
                    <div class="card-back">
                        <!-- Register Form -->
                        <form id="registerForm" action="php/register.php" method="POST" onsubmit="return validateForm();">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="fullName" name="fullName" type="text"
                                    placeholder="Enter your full name" required>
                                <label for="fullName">Full name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="defaultLocation" name="defaultLocation" type="text"
                                    placeholder="Enter your default location" required>
                                <label for="defaultLocation">Default location</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phoneNumber" name="phoneNumber" type="tel"
                                    placeholder="(123) 456-7890" required>
                                <label for="phoneNumber">Phone number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="registerEmail" name="registerEmail" type="email"
                                    placeholder="name@example.com" required>
                                <label for="registerEmail">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="newPassword" name="newPassword" type="password"
                                    placeholder="New password" required>
                                <label for="newPassword">New password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="confirmPassword" name="confirmPassword" type="password"
                                    placeholder="Confirm password" required>
                                <label for="confirmPassword">Confirm password</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary rounded-pill btn-lg" type="submit">Register</button>
                            </div>
                        </form>
                        <p class="mt-3">Already have an account? <button class="btn btn-link btn-sm"
                                id="flipButtonBack">Login</button></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>