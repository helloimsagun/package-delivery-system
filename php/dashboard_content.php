<!-- If user_type is user, show a banner image and Request Pickup button -->
<?php if ($userType == '1'): ?>
    <div class="row">
        <div class="card shadow mb-4 p-3 mx-auto">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Package Records</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <img src="images/editprofile-bg.jpg" class="img-fluid" alt="Responsive image">
                </div>
            </div>
            <a href="#" class="btn btn-primary btn-lg btn-block p-3" data-toggle="modal" data-target="#requestPickupModal">
                <span class="icon">
                    <i class="fa-solid fa-boxes-packing"></i>
                </span>
                <span class="text">Request Pickup</span>
            </a>
        </div>
    </div>
<?php endif ?>
<!-- If userType is admin, show three cards: Total Users, Total Riders, and Total Package fetched from database -->
<!-- Also include a pickup request table that can be used to assign the package or cancel the package request -->
<!-- If userType is admin -->
<?php if ($userType == '2'): ?>
    <div class="row">
        <!-- Total Users Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Query to fetch the total number of users
                                $sql = "SELECT COUNT(*) AS total_users FROM account_details WHERE type_id = 1";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_users'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Riders Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Riders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Query to fetch the total number of riders
                                $sql = "SELECT COUNT(*) AS total_riders FROM account_details WHERE type_id = 3";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_riders'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-motorcycle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Packages Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Packages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Query to fetch the total number of packages
                                $sql = "SELECT COUNT(*) AS total_packages FROM package_details";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_packages'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pickup Request Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pickup Requests</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Requested on</th>
                            <th>Sender's Account no</th>
                            <th>Sender Name</th>
                            <th>Sender's Contact no.</th>
                            <th>Receiver Name</th>
                            <th>Receiver Address</th>
                            <th>Pickup Address</th>
                            <th>Receiver Contact no.</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query to fetch the pickup requests
                        $sql = "SELECT
                                    pd.created_on,
                                    pd.order_code,
                                    ad1.account_id as sender_id,
                                    ad1.name as sender_name,
                                    ad1.phone_no as sender_phone,
                                    rd.name AS receiver_name,
                                    ad.address AS receiver_address,
                                    ad2.address AS pickup_address,
                                    rd.phone_no AS receiver_phone,
                                    ds.status_name AS delivery_status,
                                    pd.description
                                FROM
                                    package_details pd
                                JOIN
                                    account_details ad1 ON pd.account_id = ad1.account_id
                                JOIN
                                    receiver_details rd ON pd.receiver_id = rd.receiver_id
                                JOIN
                                    address_details ad ON pd.order_code = ad.order_code AND ad.address_type_id = 2
                                JOIN
                                    address_details ad2 ON pd.order_code = ad2.order_code AND ad2.address_type_id = 1
                                JOIN
                                    delivery_status ds ON pd.delivery_status_id = ds.status_id
                                WHERE
                                    pd.delivery_status_id = (SELECT status_id FROM delivery_status WHERE status_name = 'Pending for approval')";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $pickupRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($pickupRequests as $request) {
                            echo '<tr>';
                            echo '<td>' . $request['order_code'] . '</td>';
                            echo '<td>' . $request['created_on'] . '</td>';
                            echo '<td>' . $request['sender_id'] . '</td>';
                            echo '<td>' . $request['sender_name'] . '</td>';
                            echo '<td>' . $request['sender_phone'] . '</td>';
                            echo '<td>' . $request['receiver_name'] . '</td>';
                            echo '<td>' . $request['receiver_address'] . '</td>';
                            echo '<td>' . $request['pickup_address'] . '</td>';
                            echo '<td>' . $request['receiver_phone'] . '</td>';
                            echo '<td>' . $request['description'] . '</td>';
                            echo '<td>' . $request['delivery_status'] . '</td>';
                            echo '<td>
                            <a href="#" class="btn btn-primary assign-btn" data-toggle="modal" data-target="#assignModal" data-order-code="' . $request['order_code'] . '">Assign</a>
                            <a href="#" class="btn btn-danger cancel-btn" data-toggle="modal" data-target="#cancelModal" data-order-code="' . $request['order_code'] . '">Cancel</a>
                                  </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php if ($userType == '3'): ?>
    <div class="row">
        <!-- Total Package Delivered Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Packages To Be Picked Up
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Query to fetch the total number of packages delivered for the rider
                                $sql = "SELECT COUNT(*) AS total_delivered FROM package_details WHERE delivery_rider_id = :riderId AND delivery_status_id = 2";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':riderId', $accountId);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_delivered'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-truck-pickup fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Packages Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Packages in Transit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Query to fetch the total number of pending packages for the rider
                                $sql = "SELECT COUNT(*) AS total_pending FROM package_details WHERE delivery_rider_id = :riderId AND delivery_status_id = 3";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':riderId', $accountId);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_pending'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-truck-fast fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivered Packages Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Delivered Packages
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                // Query to fetch the total number of delivered packages for the rider
                                $sql = "SELECT COUNT(*) AS total_delivered FROM package_details WHERE delivery_rider_id = :riderId AND delivery_status_id = 4";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':riderId', $accountId);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo $result['total_delivered'];
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-circle-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-center">
            <h2>To be picked up</h2>
            <?php
            // Query to fetch packages to be picked up by the delivery rider
            $sql = "SELECT * FROM package_details pd
                JOIN account_details ad ON pd.account_id = ad.account_id
                JOIN address_details addr ON pd.order_code = addr.order_code
                WHERE pd.delivery_rider_id = :deliveryRiderId AND pd.delivery_status_id = 2 AND addr.address_type_id = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':deliveryRiderId', $_SESSION['account_id']);
            $stmt->execute();
            $packagesToBePickedUp = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($packagesToBePickedUp) > 0) {
                foreach ($packagesToBePickedUp as $package) {
                    echo '<div class="card mb-3">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">Order Code: ' . $package['order_code'] . '</h5>';
                    echo '<p><strong>Sender Name:</strong> ' . $package['name'] . '</p>';
                    echo '<p><strong>Sender Phone Number:</strong> ' . $package['phone_no'] . '</p>';
                    echo '<p><strong>Pick-up Address:</strong> ' . $package['address'] . '</p>';
                    echo '<form action="php/processPickedUp.php" method="POST">';
                    echo '<input type="hidden" name="order_code" value="' . $package['order_code'] . '">';
                    echo '<button type="submit" class="btn btn-primary">Mark as Picked Up</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No packages to be picked up.</p>';
            }
            ?>
        </div>
        <div class="col-md-6 text-center">
            <h2>In Transit</h2>
            <?php
            // Query to fetch packages in transit with the delivery rider
            $sql = "SELECT * FROM package_details pd
                JOIN account_details ad ON pd.account_id = ad.account_id
                JOIN receiver_details rd ON pd.receiver_id = rd.receiver_id
                JOIN address_details addr ON pd.order_code = addr.order_code
                WHERE pd.delivery_rider_id = :deliveryRiderId AND pd.delivery_status_id = 3 AND addr.address_type_id = 2";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':deliveryRiderId', $_SESSION['account_id']);
            $stmt->execute();
            $packagesInTransit = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($packagesInTransit) > 0) {
                foreach ($packagesInTransit as $package) {
                    echo '<div class="card mb-3">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">Order Code: ' . $package['order_code'] . '</h5>';
                    echo '<p><strong>Receiver Name:</strong> ' . $package['name'] . '</p>';
                    echo '<p><strong>Receiver Phone Number:</strong> ' . $package['phone_no'] . '</p>';
                    echo '<p><strong>Delivery Address:</strong> ' . $package['address'] . '</p>';
                    echo '<form action="php/processDelivered.php" method="POST">';
                    echo '<input type="hidden" name="order_code" value="' . $package['order_code'] . '">';
                    echo '<button type="submit" class="btn btn-primary">Mark as Delivered</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No packages in transit.</p>';
            }
            ?>
        </div>
    </div>


<!-- View on Map Button at the Bottom of Dashboard -->
<div class="dashboard-map-section" style="margin-top: 20px; text-align: center;">
    <a href="php/mappage.php" class="btn btn-primary">
        View on Map
    </a>
</div>

<?php endif; ?>