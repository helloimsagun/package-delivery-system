<!-- Add User Modal -->
<a href="#" class="btn btn-primary btn-icon-split btn-lg mb-4" data-toggle="modal" data-target="#addUserModal">
    <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
    </span>
    <span class="text">Add User</span>
</a>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Registered User Accounts</h6>
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
                    $sql = "SELECT account_id, name, default_location, phone_no, email FROM account_details WHERE type_id = 1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($users as $usera) {
                        echo '<tr>';
                        echo '<td>' . $usera['account_id'] . '</td>';
                        echo '<td>' . $usera['name'] . '</td>';
                        echo '<td>' . $usera['default_location'] . '</td>';
                        echo '<td>' . $usera['phone_no'] . '</td>';
                        echo '<td>' . $usera['email'] . '</td>';
                        echo '<td>
                        <button class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#editUserModal"
                            data-account-id="' . $usera['account_id'] . '" data-name="' . $usera['name'] . '"
                            data-default-location="' . $usera['default_location'] . '" data-phone="' . $usera['phone_no'] . '"
                            data-email="' . $usera['email'] . '">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#deleteUserModal"
                            data-account-id="' . $usera['account_id'] . '">Delete</button>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
