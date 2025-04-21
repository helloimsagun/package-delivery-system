<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Package Records</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Order Code</th>
            <th>Requested on</th>
            <th>Date Picked Up</th>
            <th>Date delivered</th>
            <th>Approved on</th>
            <th>Receiver's Name</th>
            <th>Receiver's Address</th>
            <th>Pickup Address</th>
            <th>Receiver's Contact no.</th>
            <th>Description</th>
            <th>Delivery Rider's Name</th>
            <th>Delivery Rider's Contact No.</th>
            <th>Delivery Status</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT
                    pd.created_on,
                    pd.date_received,
                    pd.date_delivered,
                    pd.order_code,
                    pd.date_assigned,
                    rd.name AS receiver_name,
                    ad.address AS receiver_address,
                    ad2.address AS pickup_address,
                    rd.phone_no AS receiver_phone,
                    pd.description,
                    ds.status_name AS delivery_status,
                    pd.remarks,
                    (SELECT ad.name FROM account_details ad WHERE pd.delivery_rider_id = ad.account_id) AS delivery_rider_name,
                    (SELECT ad.phone_no FROM account_details ad WHERE pd.delivery_rider_id = ad.account_id) AS delivery_rider_phone
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
                    WHERE pd.account_id = :account_id";
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':account_id', $_SESSION['account_id'], PDO::PARAM_INT);
          $stmt->execute();

          // Fetch the package data
          $packageData = $stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach ($packageData as $package) {
            echo '<tr>';
            echo '<td>' . $package['order_code'] . '</td>';
            echo '<td>' . $package['created_on'] . '</td>';
            echo '<td>' . $package['date_received'] . '</td>';
            echo '<td>' . $package['date_delivered'] . '</td>';
            echo '<td>' . $package['date_assigned'] . '</td>';
            echo '<td>' . $package['receiver_name'] . '</td>';
            echo '<td>' . $package['receiver_address'] . '</td>';
            echo '<td>' . $package['pickup_address'] . '</td>';
            echo '<td>' . $package['receiver_phone'] . '</td>';
            echo '<td>' . $package['description'] . '</td>';
            echo '<td>' . $package['delivery_rider_name'] . '</td>';
            echo '<td>' . $package['delivery_rider_phone'] . '</td>';
            echo '<td>' . $package['delivery_status'] . '</td>';
            echo '<td>' . $package['remarks'] . '</td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>