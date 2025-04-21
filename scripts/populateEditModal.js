
// Function to populate the edit modal with user details
function populateEditModal(accountId, name, defaultLocation, phone, email) {
    $('#editAccountId').val(accountId);
    $('#editName').val(name);
    $('#editDefaultAddress').val(defaultLocation);
    $('#editPhone').val(phone);
    $('#editEmail').val(email);
}
function populateDeleteModal(accountId) {
    $('#deleteAccountId').val(accountId);
}

function populateAssignModal(orderCode) {
    $('#assignOrderCodeHead').text(orderCode);
    $('#assignOrderCode').val(orderCode);
}

function populateCancelModal(orderCode) {
    $('#cancelOrderCode').val(orderCode);
}

// Event listener for edit button click
$(document).on('click', '.edit-btn', function () {
    // Get the data attributes of the clicked edit button
    var accountId = $(this).data('account-id');
    var name = $(this).data('name');
    var defaultLocation = $(this).data('default-location');
    var phone = $(this).data('phone');
    var email = $(this).data('email');

    // Populate the edit modal with user details
    populateEditModal(accountId, name, defaultLocation, phone, email);
});
$(document).on('click', '.delete-btn', function () {
    // Get the data attributes of the clicked edit button
    var accountId = $(this).data('account-id');
    populateDeleteModal(accountId);
});

$(document).on('click', '.assign-btn', function () {
    // Get the order code from the clicked assign button
    var orderCode = $(this).data('order-code');

    // Populate the assign modal with order code
    populateAssignModal(orderCode);
});

// Event listener for "Cancel" button click
$(document).on('click', '.cancel-btn', function () {
    // Get the order code from the clicked cancel button
    var orderCode = $(this).data('order-code');

    // Populate the cancel modal with order code
    populateCancelModal(orderCode);
});
// Clear the edit modal fields when it is closed
$('#editUserModal').on('hidden.bs.modal', function () {
    $('#editAccountId').val('');
    $('#editName').val('');
    $('#editDefaultAddress').val('');
    $('#editPhone').val('');
    $('#editEmail').val('');
});
$('#deleteUserModal').on('hidden.bs.modal', function () {
    $('#deleteAccountId').val('');
});

$('#assignModal').on('hidden.bs.modal', function () {
    $('#assignOrderCodeHead').text('');
    $('#assignOrderCode').val('');

});

// Clear the cancel modal fields when it is closed
$('#cancelModal').on('hidden.bs.modal', function () {
    $('#cancelOrderCode').val('');
});