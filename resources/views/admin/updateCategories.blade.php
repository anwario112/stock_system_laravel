<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your update form goes here -->
                <form id="update-form">
                    @csrf
                  <ul id="update-error"></ul>
                    <input type="hidden" name='id' id='id'>

                    <label for="categoryName">Category Name:</label>
                    <input type="text" name="categoryName" id="categoryName" class="form-control">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                    <!-- Add other fields as needed -->

                    <button type="submit" class="btns btn-primary">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
