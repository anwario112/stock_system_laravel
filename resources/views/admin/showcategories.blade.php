@extends('admin.dashboard')
@section('content')

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <div id="success_message"></div>
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>CategoryID</th>
                        <th>CategoryName</th>
                        <th>Description</th>


                    </tr>
                </thead>
                  <tbody>
                    @foreach($categories as $list)
                    <tr >
                        <td>{{ $list->CategoryID}}</td>
                        <td>{{ $list->CategoryName}}</td>
                        <td>{{ $list->description}}</td>


                        <td>
                            <button type="button" class="btn btn-primary"  data-id="{{$list->CategoryID}}" data-toggle="modal" data-target="#exampleModal">
                                Edit
                              </button>

                        </td>
                    </tr>
                @endforeach
                  </tbody>

            </table>
        </div>
    </div>
</div>
@include('admin.updateCategories')


@endsection
@section('script')

<script>
$(document).ready(function(){


    $(document).on('click', '.btn', function (e) {
    e.preventDefault();

    var id = $(this).data('id');
    $('#exampleModal').modal('show');

    $.ajax({
        type: 'GET',
        url: "/editCategories/" + id,
        dataType: "json",
        success: function (response) {
            if (response.status == 404) {
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-danger');
                $('#success_message').text(response.message);
            } else if (response.category && response.category.CategoryName !== undefined) {
                $('#categoryName').val(response.category.CategoryName);
                $('#description').val(response.category.Description);
                $('#id').val(id);
            } else {
                // Handle the case when response.category is undefined or CategoryName is not present
                console.error("Invalid response structure:", response);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});
});
$(document).on('click','.btns',function(e){
    e.preventDefault();

    var cat_id=$('#id').val();
    var data={
        'categoryName':$('#categoryName').val(),
        'description':$('#description').val(),
    }

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $.ajax({
    type: "PUT",
    url: "/updateCategory/" + cat_id,
    data: data,
    dataType: "json",
    success: function (response) {
        if (response.status == 400) {
            // ...
        } else if (response.status == 404) {
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-danger');
            $('#success_message').text(response.message);
        } else {
            $('#update-error').html("");
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message);
            $('#exampleModal').modal('hide');
        }
    }
});
});



      </script>
@endsection
