<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Delivered Packages Table</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>Requested On</th>
                        <th>Date Assigned</th>
                        <th>Date Picked Up</th>
                        <th>Date Delivered</th>
                        <th>Sender's Account no</th>
                        <th>Sender Name</th>
                        <th>Receiver's Name</th>
                        <th>Receiver's Address</th>
                        <th>Pickup Address</th>
                        <th>Receiver's Contact No.</th>
                        <th>Description</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $accountId = $_SESSION['account_id'];
                    $sql = "SELECT
                                pd.order_code,
                                pd.created_on,
                                pd.date_assigned,
                                pd.date_received,
                                pd.date_delivered,
                                ad1.account_id as sender_id,
                                ad1.name as sender_name,
                                rd.name AS receiver_name,
                                ad.address AS receiver_address,
                                ad2.address AS pickup_address,
                                rd.phone_no AS receiver_phone,
                                pd.description,
                                pd.remarks
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
                                delivery_rider_id = :accountId
                                AND
                                delivery_status_id = 4";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':accountId', $accountId);
                    $stmt->execute();

                    // Fetch the package data
                    $packageData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($packageData as $package) {
                        echo '<tr>';
                        echo '<td>' . $package['order_code'] . '</td>';
                        echo '<td>' . $package['created_on'] . '</td>';
                        echo '<td>' . $package['date_assigned'] . '</td>';
                        echo '<td>' . $package['date_received'] . '</td>';
                        echo '<td>' . $package['date_delivered'] . '</td>';
                        echo '<td>' . $package['sender_id'] . '</td>';
                        echo '<td>' . $package['sender_name'] . '</td>';
                        echo '<td>' . $package['receiver_name'] . '</td>';
                        echo '<td>' . $package['receiver_address'] . '</td>';
                        echo '<td>' . $package['pickup_address'] . '</td>';
                        echo '<td>' . $package['receiver_phone'] . '</td>';
                        echo '<td>' . $package['description'] . '</td>';
                        echo '<td>' . $package['remarks'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>