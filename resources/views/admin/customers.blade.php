@extends('admin.dashboard')
@section('content')


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customers Data</h6>
                        </div>
                        <nav class="navbar navbar-light bg-light">
                            <form class="frmsearch form-inline">
                                @csrf
                                <label for="search" class="sr-only">Products Search</label>
                                <input id="search" class="form-control mr-sm-2" type="search" placeholder="Customer Search" name="search" style="margin-left: 10px; width: 350px;" aria-label="Search" >
                            </form>
                        </nav>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ContactName</th>
                                            <th>CompanyName</th>
                                            <th>Phone</th>
                                            <th>Details</th>

                                        </tr>
                                    </thead>
                                      <tbody id="customer-search">
                                        @foreach($customers as $customer)
                                        <tr>
                                            <td>{{ $customer['ContactName'] }}</td>
                                            <td>{{ $customer['CompanyName'] }}</td>
                                            <td>{{ $customer['Phone'] }}</td>
                                            <td>
                                                <button type="button" class="userinfo btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $customer['CustomerID'] }}">Details</button>
                                            </td>
                                            <td>
                                                <button type="button" class="userinfo btn btn-primary" data-bs-toggle="modal" data-bs-target="#order_detail" data-id="{{ $customer['OrderID'] }}">View</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                      </tbody>

                                </table>
                                {!! $customers->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>

@section('script')

<script>
    $('body').on('keyup', '#search', function () {
        var customerSearch = $(this).val();

$.ajax({
    method: 'POST',
    url: '{{ route("customerSearch") }}',
    dataType: 'json',
    data: {
        '_token': '{{ csrf_token() }}',
        customerSearch: customerSearch
    },
    success: function (response) {
        var customerRow = '';

        $('#customer-search').html('');
        $.each(response, function (index, value) {
            customerRow += '<tr>\
                            <td>' + value.ContactName + '</td>\
                            <td>' + value.CompanyName + '</td>\
                            <td>' + value.Phone + '</td>\
                            <td>\
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="' + value.CustomerID + '">Details</button>\
                            </td>\
                            <td>\
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#order_detail" data-id="' + value.OrderID + '">View</button>\
                            </td>\
                          </tr>';
        });

        $('#customer-search').append(customerRow);
    }
});

});
</script>
@endsection


@endsection
