document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('requestPickupForm');
    const phoneInput = document.getElementById('receiverPhone');

    form.addEventListener('submit', function(event) {
        if (!isValidPhoneNumber(phoneInput.value)) {
            event.preventDefault();
            alert('Please enter a valid 10-digit phone number.');
            phoneInput.focus();
        }
    });

    phoneInput.addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });

    function isValidPhoneNumber(phone) {
        const phoneRegex = /^[0-9]{10}$/;
        return phoneRegex.test(phone);
    }
});
