<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="php/logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Setting Modal -->
<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="settingModalLabel">Settings</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Profile Setting Form -->
                <form action="php/updateProfile.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo $user['phone_no']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter your location" value="<?php echo $user['default_location']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>

                </form>
                <hr>
                <form action="php/updatePassword.php" method="POST">

                    <!-- Password Setting Form -->
                    <div class="form-group">
                        <label for="oldPassword">Old Password</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Enter your old password" required>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter your new password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password" required>
                    </div>

                    <button type="submit" class="btn btn-primary" onsubmit="validateForm();">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add this HTML code after the form in dashboard.php -->
<div class="modal fade" id="successPasswordModal" tabindex="-1" role="dialog" aria-labelledby="successPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successPasswordModalLabel">Password Update Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessPasswordModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Your password has been successfully updated.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successProfileModal" tabindex="-1" role="dialog" aria-labelledby="successProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successProfileModalLabel">Profile Update Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessProfileModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Your Profile has been successfully updated.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successRequestModal" tabindex="-1" role="dialog" aria-labelledby="successRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successRequestModalLabel">Request record Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessRequestModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Your Request has been successfully recorded.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="requestPickupModal" tabindex="-1" role="dialog" aria-labelledby="requestPickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestPickupModalLabel">Request Pickup</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="php/processRequestPickup.php" method="POST">
                <div class="form-group">
                    <label for="pickupAddress">Pickup Address</label>
                    <input type="text" class="form-control" id="pickupAddress" name="pickupAddress" required>
                    <input type="hidden" id="pickup_latitude" name="pickup_latitude" value="">
                    <input type="hidden" id="pickup_longitude" name="pickup_longitude" value="">
                </div>
                <div class="form-group">
                    <label for="receiverName">Receiver's Name</label>
                    <input type="text" class="form-control" id="receiverName" name="receiverName" required>
                </div>
                <div class="form-group">
                    <label for="deliveryAddress">Delivery Address</label>
                    <input type="text" class="form-control" id="deliveryAddress" name="deliveryAddress" required>
                    <input type="hidden" id="dropoff_latitudes" name="dropoff_latitudes" value="">
                    <input type="hidden" id="dropoff_longitudes" name="dropoff_longitudes" value="">
                </div>
                <div class="form-group">
                        <label for="receiverPhone">Receiver's Phone Number</label>
                        <input type="tel" class="form-control" id="receiverPhone" name="receiverPhone" required pattern="[0-9]{10}" title="Phone number must be 10 digits">
                        <small class="form-text text-muted">Enter a 10-digit phone number without spaces or dashes.</small>
                    </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="map">Map</label>
                    <div id="map" style="height: 300px;"></div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Assign Delivery Personnel for Order Code <span id="assignOrderCodeHead"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="php/processAssign.php" method="POST">
                    <input type="hidden" name="order_code" id="assignOrderCode">
                    <div class="form-group">
                        <label for="deliveryPersonnel">Select Delivery Personnel:</label>
                        <select class="form-control" name="delivery_personnel" id="deliveryPersonnel">
                            <?php
                            // Query to fetch the delivery personnel
                            $sql = "SELECT account_id, name FROM account_details WHERE type_id = 3";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $deliveryPersonnel = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($deliveryPersonnel as $personnel) {
                                echo "<option value='" . $personnel['account_id'] . "'>" . $personnel['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="assignRemarks">Remarks:</label>
                        <textarea class="form-control" name="assign_remarks" id="assignRemarks" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Pickup Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="php/processCancel.php" method="POST">
                    <input type="hidden" name="order_code" id="cancelOrderCode">
                    <div class="form-group">
                        <label for="remarks">Remarks:</label>
                        <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Cancel Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successAssignModal" tabindex="-1" role="dialog" aria-labelledby="successAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successAssignModalLabel">Package Assignment Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessAssignModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Delivery Personnel assignment has been successfully recorded.
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successCancelModal" tabindex="-1" role="dialog" aria-labelledby="successCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successCancelModalLabel">Package Cancellation Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessCancelModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Package has been cancelled.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- User registration form -->
                <form action="php/user_register_by_admin.php" method="POST">
                    <div class="form-group">
                        <label for="fullName">Full Name:</label>
                        <input type="text" class="form-control" name="name" id="fullName" required>
                    </div>
                    <div class="form-group">
                        <label for="defaultLocation">Default Address:</label>
                        <input type="text" class="form-control" name="default_location" id="defaultLocation" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number:</label>
                        <input type="text" class="form-control" name="phone" id="phoneNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="registerEmail">Email:</label>
                        <input type="email" class="form-control" name="email" id="registerEmail" required>
                    <div class="form-group">
                        <label for="vehicleType">Vehicle Type:</label>
                        <select class="form-control" name="vehicle_type" id="vehicleType" required>
                            <option value="" disabled selected>Select a vehicle type</option>
                            <option value="Bicycle">Bicycle (up to 5kg)</option>
                            <option value="Bike">Bike (up to 20kg)</option>
                            <option value="Mini Truck">Mini Truck (up to 100kg)</option>
                            <option value="Truck">Truck (over 100kg)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newPasswordAdmin">Password:</label>
                        <input type="password" class="form-control" name="password" id="newPasswordAdmin" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- User Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- User edit form -->
                <form action="php/adminUpdateProfile.php" method="POST">
                    <input type="hidden" name="account_id" id="editAccountId">
                    <div class="form-group">
                        <label for="editName">Name:</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="form-group">
                        <label for="editDefaultAddress">Default Address:</label>
                        <input type="text" class="form-control" name="default_address" id="editDefaultAddress" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone Number:</label>
                        <input type="text" class="form-control" name="phone" id="editPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email:</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Confirmation Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm User Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this user?</p>
            </div>
            <div class="modal-footer">
                <form action="php/adminDeleteUser.php" method="POST">
                    <input type="hidden" name="account_id" id="deleteAccountId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successRegisterModal" tabindex="-1" role="dialog" aria-labelledby="successRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successRegisterModalLabel">Registration Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessRegisterModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                User has been registered.
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successRegisterDrModal" tabindex="-1" role="dialog" aria-labelledby="successRegisterDrModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successRegisterDrModalLabel">Registration Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessRegisterDrModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Delivery rider has been registered.
            </div>
        </div>
    </div>
</div>


<!-- successDeleteModal -->

<div class="modal fade" id="successDeleteModal" tabindex="-1" role="dialog" aria-labelledby="successDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successDeleteModalLabel">Delete Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessDeleteModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                User has been deleted.
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successDeleteDrModal" tabindex="-1" role="dialog" aria-labelledby="successDeleteDrModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successDeleteDrModalLabel">Delete Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessDeleteDrModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Delivery Rider has been deleted.
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successAdminUpdateModal" tabindex="-1" role="dialog" aria-labelledby="successAdminUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successAdminUpdateModalLabel">Update Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessAdminUpdateModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                User details have been updated.
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="successAdminUpdateDrModal" tabindex="-1" role="dialog" aria-labelledby="successAdminUpdateDrModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successAdminUpdateDrModalLabel">Update Successful</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close" onclick="closeSuccessAdminUpdateDrModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Delivery Rider details have been updated.
            </div>
        </div>
    </div>
</div>

<!-- Include MapLibre CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="scripts/address-pinpoint.js"></script>
