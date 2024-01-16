$(document).ready(function() {
    // Add this line to set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.userinfo').click(function(e) {
        e.preventDefault();
        var custID = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/customer-order/' + custID,
            dataType: 'json', // Assuming the server returns JSON
            success: function(data) {
                var orders = data; // Access data directly
                var htmlContent = '';

                for (var i = 0; i < orders.length; i++) {
                    htmlContent += '<div>';
                    htmlContent += '<p>Order ID: ' + orders[i].OrderID + '</p>';
                    htmlContent += '<p>Order Date: ' + orders[i].OrderDate + '</p>';
                    htmlContent += '<p>Total: ' + orders[i].tot + '</p>';
                    htmlContent += '</div>';
                    htmlContent += '<hr>';
                }

                $('#exampleModal .modal-body').html(htmlContent);
                $('#exampleModal').modal('show');
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});
