@extends('admin.dashboard')
@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products Data</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ProductName</th>
                            <th>Qunanity</th>
                            <th>UnitPrice</th>
                            <th>Cover</th>
                            <th>Edit</th>

                        </tr>
                    </thead>
                      <tbody>
                        @foreach($show as $list)
                        <tr id="sid{{$list->ProductID}}">
                            <td>{{ $list->ProductName }}</td>
                            <td>{{ $list->QuantityPerUnit }}</td>
                            <td>{{ $list->UnitPrice }}</td>
                            <td>
                                <img src="{{ $list->image_url }}" alt="Product Cover" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-id="{{$list->ProductID}}"  data-toggle="modal" data-target="#exampleModal">
                                    Edit
                                  </button>

                            </td>
                        </tr>
                    @endforeach
                      </tbody>

                </table>
                {!! $show->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
   @include('admin.updateproduct')

  @section('script')
  <script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.btn', function(e) {
    var productID = $(this).data('id');
    $.post('<?= route("product.Details") ?>', { productID: productID }, function(data) {
        // Assuming you have an <img> tag with the id "productImage" in your modal
        $("#exampleModal").find('#productImage').attr('src', data.details.product_cover);

        // Set other fields based on the received data
        $("#exampleModal").find('input[name="productName"]').val(data.details.ProductName);
        $("#exampleModal").find('input[name="CompanyName"]').val(data.details.CategoryName);
        $("#exampleModal").find('input[name="CategoryID"]').val(data.details.CategoryID);
        $("#exampleModal").find('input[name="quantityPerUnit"]').val(data.details.QuantityPerUnit);
        $("#exampleModal").find('input[name="unitPrice"]').val(data.details.UnitPrice);
        $("#exampleModal").find('input[name="unitsInStock"]').val(data.details.UnitsInStock);
        $("#exampleModal").find('input[name="unitsOnOrder"]').val(data.details.UnitsOnOrder);

        $("#exampleModal").modal('show');
    }, 'json');
});

$("#update-form").on('submit',function(e){
    e.preventDefault();
    var form=this;
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        Data:new FormData(form),
        processData:false,
        datatype:'json',
        contenttype:false,
        beforesend:function(){
            $(form).find('.submit-button').prop('disabled', true);
        },
        success:function(data){
            if(data.code==0){
                $.each(data.error,function(prefix,val){
                    $(form).find('submit' +prefix).text(val[0]);
                });
            }else{
                $("#exampleModal").modal('hide');
                $('#exampleModal').find('form')[0].reset();
                toastr.success(data.msg);
            }

        }

    })
})
  </script>
  @endsection

@endsection
