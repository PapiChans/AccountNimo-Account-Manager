<div id="addCategoryModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('categories.store') }}" method="post" id="addCategoryForm">
                @csrf
                <input type="hidden" name="vault_id" id="add_vault_id">
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Please fill up the <b>required</b> fields.
                    </div>
                    <label for="label" class="form-label">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="mt-2"></div>
                    <label for="label" class="form-label">Color</label>
                    <input type="color" name="color" id="color" class="form-control form-control-color w-100" value="#364574">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addCategorySubmit">Create Category</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="editCategoryModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('categories.update') }}" method="post" id="editCategoryForm">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Please fill up the <b>required</b> fields.
                    </div>
                    <label for="label" class="form-label">Category Name</label>
                    <input type="text" name="edit_name" id="edit_name" class="form-control">
                    <div class="mt-2"></div>
                    <label for="label" class="form-label">Color</label>
                    <input type="color" name="edit_color" id="edit_color" class="form-control form-control-color w-100" value="#364574">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editCategorySubmit">Edit Category</button>
                </div>
            </form>

        </div>
    </div>
</div>