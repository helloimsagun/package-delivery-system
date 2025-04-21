<title>Home Page</title>

</head>

<body id="page-top">
  <?php include 'php/navbar.php'; ?>
  <!-- Masthead-->
  <header class="masthead" id="home">
    <div class="container">
      <div class="masthead-subheading">Order Code</div>

      <?php
      $orderCode = $_POST['orderCode'];

      // Query the database to fetch package details based on order code
      $stmt = $pdo->prepare("SELECT pd.order_code, ad1.address AS pickup_address, ad2.address AS delivery_address, account_details.name AS sender_name, receiver_details.name AS receiver_name, pd.date_received, pd.date_delivered, delivery_status.status_name AS delivery_status FROM package_details pd JOIN account_details ON pd.account_id = account_details.account_id JOIN receiver_details ON pd.receiver_id = receiver_details.receiver_id JOIN delivery_status ON pd.delivery_status_id = delivery_status.status_id JOIN address_details ad1 ON pd.order_code = ad1.order_code AND ad1.address_type_id = 1 JOIN address_details ad2 ON pd.order_code = ad2.order_code AND ad2.address_type_id = 2 WHERE pd.order_code = :orderCode;");
      $stmt->bindParam(':orderCode', $orderCode);
      $stmt->execute();
      $package = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($package) {
        // Package details found, display them
        $orderCode = $package['order_code'];
        $senderName = $package['sender_name'];
        $receiverName = $package['receiver_name'];
        $dateReceived = $package['date_received'];
        $dateDelivered = $package['date_delivered'];
        $pickupAddress = $package['pickup_address'];
        $deliveryAddress = $package['delivery_address'];
        $deliveryStatus = $package['delivery_status'];
        echo '<div class="alert alert-danger">
        <h6>Order Code: ' . $orderCode . '</h6>
        <h6>Sender: ' . $senderName . '</h6>
        <h6>Receiver: ' . $receiverName . '</h6>
        <h6>Date Received: ' . $dateReceived . '</h6>
        <h6>Date Delivered: ' . $dateDelivered . '</h6>
        <h6>Pickup Address: ' . $pickupAddress . '</h6>
        <h6>Delivery Address: ' . $deliveryAddress . '</h6>
        <h6>Delivery Status: ' . $deliveryStatus . '</h6>
        </div>';
      } else {
        // Package not found, display an error message
        echo '<div class="alert alert-danger" role="alert">
                Package not found. Please check the order code and try again.
              </div>';
      }
      ?>
    </div>
  </header>