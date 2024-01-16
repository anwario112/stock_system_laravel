@extends('admin.dashboard')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div id="success_message"></div>
        <h6 class="m-0 font-weight-bold text-primary">Outgoing Products</h6>
    </div>

    <div class="card-body">
        <a href="{{ route('export_pdf') }}" class="btn btn-primary" style="width: 150px; margin-top: 10px; margin-left: 33px;">Export To PDF</a>

        <nav class="navbar navbar-light bg-light">
            <form class="frmsearch form-inline">
                @csrf
                <label for="search" class="sr-only">Products Search</label>
                <input id="search" class="form-control mr-sm-2" type="search" placeholder="Products Search" name="search" style="margin-left: 30px; width: 350px;" aria-label="Search" >
            </form>
        </nav>

        <div class="table-responsive">
            <table id="example" class="table table-striped" style="width: 100%">
                <thead>
                    <tr>
                        <th>Products</th>
                        <th>CompanyName</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody id="dynamic-row">
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->ProductName }}</td>
                        <td>{{ $order->CompanyName }}</td>
                        <td>{{ $order->Quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->OrderDate)->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $orders->links('pagination::bootstrap-4') !!}
        </div>
    </div>

    <div id="result"></div>

</div>

@section("script")
   <script>
   $('body').on('keyup', '#search', function () {
    var searchQuest = $(this).val();

    $.ajax({
    method: 'POST',
    url: '{{ route("search") }}',
    dataType: 'json',
    data: {
        '_token': '{{ csrf_token() }}',
        searchQuest: searchQuest,
    },
    success: function (response) {
        var tableRow = '';

        $('#dynamic-row').html('');

        $.each(response, function (index, value) {
            tableRow += '<tr>\
                            <td>' + value.ProductName + '</td>\
                            <td>' + value.CompanyName + '</td>\
                            <td>' + value.Quantity + '</td>\
                            <td>' + value.OrderDate + '</td>\
                         </tr>';
        });

        $('#dynamic-row').append(tableRow);
    },
    error: function (xhr, status, error) {
        console.error(xhr.responseText); // Log the error response
    }
});
});
   </script>
@endsection

@endsection
