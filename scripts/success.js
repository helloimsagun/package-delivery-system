// Function to show the success password modal and clear the URL parameter
function showSuccessPasswordModal() {
    $('#successPasswordModal').modal('show');
    clearUrlParameter('successPassword');
}

// Function to show the success profile modal and clear the URL parameter
function showSuccessProfileModal() {
    $('#successProfileModal').modal('show');
    clearUrlParameter('successProfile');
}

// Function to show the success request modal and clear the URL parameter
function showSuccessRequestModal(){
    $('#successRequestModal').modal('show');
    clearUrlParameter('successRequest');
}

// Function to show the success assign modal and clear the URL parameter
function showSuccessAssignModal(){
    $('#successAssignModal').modal('show');
    clearUrlParameter('successAssign');
}

// Function to show the success cancel modal and clear the URL parameter
function showSuccessCancelModal(){
    $('#successCancelModal').modal('show');
    clearUrlParameter('successCancel');
}

// Function to show the success register modal and clear the URL parameter
function showSuccessRegisterModal(){
    $('#successRegisterModal').modal('show');
    clearUrlParameter('successRegister');
}

// Function to show the success register delivery rider modal and clear the URL parameter
function showSuccessRegisterDrModal(){
    $('#successRegisterDrModal').modal('show');
    clearUrlParameter('successRegisterDr');
}

// Function to show the success delete modal and clear the URL parameter
function showSuccessDeleteModal(){
    $('#successDeleteModal').modal('show');
    clearUrlParameter('successDelete');
}

// Function to show the success delete delivery rider modal and clear the URL parameter
function showSuccessDeleteDrModal(){
    $('#successDeleteDrModal').modal('show');
    clearUrlParameter('successDeleteDr');
}

// Function to show the success admin update modal and clear the URL parameter
function showSuccessAdminUpdateModal(){
    $('#successAdminUpdateModal').modal('show');
    clearUrlParameter('successAdminUpdate');
}

// Function to show the success admin update delivery rider modal and clear the URL parameter
function showSuccessAdminUpdateDrModal(){
    $('#successAdminUpdateDrModal').modal('show');
    clearUrlParameter('successAdminUpdateDr');
}

// Function to clear the URL parameter
// Function to clear the URL parameter
function clearUrlParameter(parameter) {
    const url = new URL(window.location.href);
    url.searchParams.delete(parameter);
    const newUrl = url.href.split('?')[0]; // Remove any remaining query parameters
    window.history.replaceState({}, document.title, newUrl);
}


$(document).ready(function () {
    // Check if the URL contains the success parameter and display the respective modals
    const urlParams = new URLSearchParams(window.location.search);
    const successPassword = urlParams.get('successPassword');
    const successProfile = urlParams.get('successProfile');
    const successRequest = urlParams.get('successRequest');
    const successAssign = urlParams.get('successAssign');
    const successCancel = urlParams.get('successCancel');
    const successRegister = urlParams.get('successRegister');
    const successRegisterDr = urlParams.get('successRegisterDr');
    const successDelete = urlParams.get('successDelete');
    const successDeleteDr = urlParams.get('successDeleteDr');
    const successAdminUpdate = urlParams.get('successAdminUpdate');
    const successAdminUpdateDr = urlParams.get('successAdminUpdateDr');

    if (successPassword === 'true') {
        showSuccessPasswordModal();
    }
    if (successProfile === 'true') {
        showSuccessProfileModal();
    }
    if (successRequest === 'true'){
        showSuccessRequestModal();
    }
    if (successAssign === 'true'){
        showSuccessAssignModal();
    }
    if (successCancel === 'true'){
        showSuccessCancelModal();
    }
    if (successRegister === 'true'){
        showSuccessRegisterModal();
    }
    if (successRegisterDr === 'true'){
        showSuccessRegisterDrModal();
    }
    if (successDelete === 'true'){
        showSuccessDeleteModal();
    }
    if (successDeleteDr === 'true'){
        showSuccessDeleteDrModal();
    }
    if (successAdminUpdate === 'true'){
        showSuccessAdminUpdateModal();
    }
    if (successAdminUpdateDr === 'true'){
        showSuccessAdminUpdateDrModal();
    }
});

// On click of close button on success modal, hide the modal
function closeSuccessPasswordModal() {
    $('#successPasswordModal').modal('hide');
}

function closeSuccessProfileModal() {
    $('#successProfileModal').modal('hide');
}

function closeSuccessRequestModal(){
    $('#successRequestModal').modal('hide');
}

function closeSuccessAssignModal(){
    $('#successAssignModal').modal('hide');
}

function closeSuccessCancelModal(){
    $('#successCancelModal').modal('hide');
}

function closeSuccessRegisterModal(){
    $('#successRegisterModal').modal('hide');
}

function closeSuccessRegisterDrModal(){
    $('#successRegisterDrModal').modal('hide');
}

function closeSuccessDeleteModal(){
    $('#successDeleteModal').modal('hide');
}

function closeSuccessDeleteDrModal(){
    $('#successDeleteDrModal').modal('hide');
}

function closeSuccessAdminUpdateModal(){
    $('#successAdminUpdateModal').modal('hide');
}

function closeSuccessAdminUpdateDrModal(){
    $('#successAdminUpdateDrModal').modal('hide');
}
