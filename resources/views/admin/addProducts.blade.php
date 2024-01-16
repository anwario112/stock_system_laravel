@extends('admin.dashboard')
@section('content')



<form class="form-horizontal" method="POST" action="{{ route('productStore') }}" enctype="multipart/form-data">
    @csrf
<fieldset>


<!-- Form Name -->
<legend> ADD PRODUCTS</legend>

<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="product_id">PRODUCT NAME</label>
<div class="col-md-4">
@error('productName')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
<input id="product_id" name="productName" placeholder="PRODUCT NAME" class="form-control input-md" type="text">

</div>
</div>



<!-- Select Basic -->
<div class="form-group">
<label class="col-md-4 control-label" for="product_categorie">COMPANY NAME</label>
<div class="col-md-4">
<select id="product_categorie" name="CompanyName" class="form-control">
@foreach($companyName as $compName)
<option name="SupplierID" value="{{ $compName->SupplierID}}">{{ $compName->CompanyName}}</option>
@endforeach
</select>

</div>
</div>
<!-- Select Basic -->
<div class="form-group">
<label class="col-md-4 control-label" for="product_categorie">CATEGORY ID</label>
<div class="col-md-4">
<select id="product_categorie" name="CategoryID" class="form-control">
@foreach($categories as $category)
<option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
@endforeach
</select>

</div>
</div>

<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="product_name_fr">QUANTITY PER UNIT</label>
<div class="col-md-4">
@error('quantityPerUnit')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
<input id="product_name_fr" name="quantityPerUnit" placeholder="QUANTITY PER UNIT" class="form-control input-md"  type="text">
</div>
</div>



<!-- Text input-->
<div class="form-group">
<label class="col-md-4 control-label" for="available_quantity">UNIT PRICE</label>
<div class="col-md-4">
@error('unitPrice')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
<input id="available_quantity" name="unitPrice" placeholder="UNIT PRICE"class="form-control input-md"  type="text">

</div>
</div>

<!-- Text input-->
<div class="form-group" id="stoc_id">
<label class="col-md-4 control-label"id="stocks" for="stocks">UNITS IN STOCK</label>
<div class="col-md-4">
@error('unitsInStock')
<div class="alert alert-danger" id="alerts" role="alert">{{ $message }}</div>
@enderror
<input id="stock" name="unitsInStock" placeholder="UNITS IN STOCK"class="form-control input-md"  type="text">

</div>
</div>


<div class="form-group">
<label class="col-md-4 control-label" id="orders"for="">UNITS  ON ORDER</label>
<div class="col-md-4">
@error('unitsOnOrder')
<div class="alert alert-danger" id="alerting" role="alert">{{ $message }}</div>
@enderror
<input id="order" name="unitsOnOrder" placeholder="UNITS IN ORDER" class="form-control input-md"  type="text">

</div>
</div>

<!-- File Button -->
<div class="form-group" id="images">
<label class="col-md-4 control-label" for="filebutton">IMAGES</label>
<div class="col-md-4">
@error('productImage')
<div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror
<input id="filebutton" name="productImage"  class="input-file" accept="image/*" type="file">

</div>
</div>

<!-- Button -->
<div class="form-group" id="botton">
<div class="col-md-4 button">
<button  name="" class="btn btn-primary">Save</button>
</div>
</div>

</fieldset>
</form>


@endsection

