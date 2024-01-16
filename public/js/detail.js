$(document).ready(function () {
    $('.orderinfo').click(function (e) {
        e.preventDefault();
        var ordID = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/orderDetail/' + ordID,
            data: { ordID: ordID },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var orderDetail = data.order_detail;
                var customerOrder = data.customerOrder;

                // Handle orderDetail
                var orderDetailHtml = '';
                for (var i = 0; i < orderDetail.length; i++) {
                    orderDetailHtml += '<div>';
                    orderDetailHtml += '<p>Order ID: ' + orderDetail[i].OrderID + '</p>';
                    orderDetailHtml += '<p>Order Date: ' + orderDetail[i].OrderDate + '</p>';
                    // Add other fields as needed
                    orderDetailHtml += '</div>';
                    orderDetailHtml += '<hr>';
                }

                // Handle customerOrder
                var customerOrderHtml = '';
                for (var j = 0; j < customerOrder.length; j++) {
                    customerOrderHtml += '<div>';
                    customerOrderHtml += '<p>Company Name: ' + customerOrder[j].CompanyName + '</p>';
                    customerOrderHtml += '<p>Contact Name: ' + customerOrder[j].ContactName + '</p>';
                    // Add other fields as needed
                    customerOrderHtml += '</div>';
                    customerOrderHtml += '<hr>';
                }

                // Display data in modal
                $('#order_detail .order-modal-body').html(orderDetailHtml);
                $('#order_detail .customer-modal-body').html(customerOrderHtml);

                // Show the modal
                $('#order_detail').modal('show');
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
