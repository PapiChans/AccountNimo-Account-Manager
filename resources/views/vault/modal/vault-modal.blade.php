<div id="addVaultModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Vault</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('vault.store') }}" method="post" id="addVaultForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Please fill up the <b>required</b> fields.
                    </div>
                    <label for="label" class="form-label">Vault Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addVaultSubmit">Create Vault</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="editVaultModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Vault</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('vault.update') }}" method="post" id="editVaultForm">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Please fill up the <b>required</b> fields.
                    </div>
                    <label for="label" class="form-label">Vault Name</label>
                    <input type="text" name="edit_name" id="edit_name" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editVaultSubmit">Update Vault</button>
                </div>
            </form>

        </div>
    </div>
</div>