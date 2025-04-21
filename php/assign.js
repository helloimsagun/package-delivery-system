console.log('SwiftStream Dashboard loaded');
$(document).ready(function() {

    setInterval(function() {
        location.reload();
    }, 10000);

    $('#autoAssignBtn').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'view_assignments.php',
            type: 'POST',
            data: { auto_assign: true },
            success: function() {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + error);
                $('#message').text("An error occurred during auto-assignment.").show();
            }
        });
    });

    if ($('#message').length > 0) {
        setTimeout(function() {
            $('#message').fadeOut();
        }, 5000);
    }
});