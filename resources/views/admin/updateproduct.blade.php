   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id=productForm>
            <form class="form-horizontal" method="POST" action="{{ route('updateProducts') }}" id="update-form" enctype="multipart/form-data">
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
            <input id="productName" name="productName" placeholder="PRODUCT NAME" class="form-control input-md" type="text">

            </div>
            </div>



            <!-- Select Basic -->
            <div class="form-group">
            <label class="col-md-4 control-label" for="product_categorie">COMPANY NAME</label>
            <div class="col-md-4">
            <select id="categoryName" name="CompanyName" class="form-control">

            <option name="SupplierID" ></option>

            </select>

            </div>
            </div>
            <!-- Select Basic -->
            <div class="form-group">
            <label class="col-md-4 control-label" for="product_categorie">CATEGORY ID</label>
            <div class="col-md-4">
            <select id="categoryID" name="CategoryID" class="form-control">

            <option ></option>

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
            <input id="quantity" name="quantityPerUnit" placeholder="QUANTITY PER UNIT" class="form-control input-md"  type="text">
            </div>
            </div>



            <!-- Text input-->
            <div class="form-group">
            <label class="col-md-4 control-label" for="available_quantity">UNIT PRICE</label>
            <div class="col-md-4">
            @error('unitPrice')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
            <input id="unitPrice" name="unitPrice" placeholder="UNIT PRICE"class="form-control input-md"  type="text">

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
            <input id="image" name="productImage"  class="input-file" accept="image/*" type="file">

            </div>
            </div>



            </fieldset>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button"id="update-form" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
