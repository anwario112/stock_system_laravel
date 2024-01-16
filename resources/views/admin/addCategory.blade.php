@extends('admin.dashboard')
@section('content')


<div class="container-fluid">

    <form class="form-horizontal" method="POST" action="{{ route('categoryStore') }}">
        @csrf
<fieldset>

<!-- Form Name -->
<legend>CATEGORIES</legend>



<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="product_id">CATEGORY NAME</label>
<div class="col-md-4">
@error('categoryName')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
<input id="product_id" name="categoryName" placeholder="CATEGORY NAME" class="form-control input-md" type="text">

</div>
</div>



<!-- Textarea -->
<div class="form-group">
<label class="col-md-4 control-label" for="product_description">DESCRIPTION</label>
<div class="col-md-4">
@error('description')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
<textarea class="form-control" id="product_description" name="description"></textarea>
</div>
</div>
<!-- Button -->
<div class="form-group">
<label class="col-md-4 control-label" for="singlebutton"></label>
<div class="col-md-4">
<button id="singlebutton" name="singlebutton" class="btn btn-primary">Button</button>
</div>
</div>


</fieldset>
</form>

@endsection
