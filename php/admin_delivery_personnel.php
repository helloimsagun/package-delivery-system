<!-- Add User Modal -->
<a href="#" class="btn btn-primary btn-icon-split btn-lg mb-4" data-toggle="modal" data-target="#addUserModal">
    <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
    </span>
    <span class="text">Add Delivery Rider</span>
</a>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Registered Delivery Rider Accounts</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Name</th>
                        <th>Default Address</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch registered user accounts
                    $sql = "SELECT account_id, name, default_location, phone_no, email FROM account_details WHERE type_id = 3";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($users as $userd) {
                        echo '<tr>';
                        echo '<td>' . $userd['account_id'] . '</td>';
                        echo '<td>' . $userd['name'] . '</td>';
                        echo '<td>' . $userd['default_location'] . '</td>';
                        echo '<td>' . $userd['phone_no'] . '</td>';
                        echo '<td>' . $userd['email'] . '</td>';
                        echo '<td>
                        <button class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#editUserModal"
                            data-account-id="' . $userd['account_id'] . '" data-name="' . $userd['name'] . '"
                            data-default-location="' . $userd['default_location'] . '" data-phone="' . $userd['phone_no'] . '"
                            data-email="' . $userd['email'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteUserModal"
                            data-account-id="' . $userd['account_id'] . '">Delete</button>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
