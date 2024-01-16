<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="card-header py-3">
        <div id="success_message"></div>
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Products</th>
                        <th>CompanyName</th>
                        <th>orderDate</th>
                        <th>Qty</th>


                    </tr>
                </thead>
                  <tbody>
                    @foreach($orders as $order)
                    <tr >
                        <td>{{ $order->ProductName}}</td>
                        <td>{{ $order->CompanyName}}</td>
                        <td>{{ $order->Quantity}}</td>
                        <td>{{ \Carbon\Carbon::parse($order->OrderDate)->format('Y-m-d') }}</td>




                    </tr>
                @endforeach
                  </tbody>

            </table>
            
        </div>

     </div>
</body>
</html>
