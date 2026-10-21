<div id="addAccountModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('account.store') }}" method="post" id="addAccountForm">
                @csrf
                <input type="hidden" name="category_id" id="category_id">
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Please fill up the <b>required</b> fields.
                    </div>
                    <div>
                        <label for="label" class="form-label">Account Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="addRequireCredential" id="addRequireCredential">
                        <label class="form-check-label" for="formCheck1">
                            This account has own credentials
                        </label>
                    </div>
                    <div class="mt-2">
                        <label for="label" class="form-label">Username / Email Address</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="mt-2">
                        <label class="form-label" for="password">Password</label>

                        <div class="position-relative auth-pass-inputgroup">
                            <input name="password" type="password" class="form-control pe-5 password-input" id="password">
                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="addTogglePassword">
                                <i class="ri-eye-fill align-middle" id="addTogglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="label" class="form-label">Notes</label>
                        <input type="text" name="notes" id="notes" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addAccountSubmit">Add Account</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="editAccountModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('account.update') }}" method="post" id="editAccountForm">
                @csrf
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Please fill up the <b>required</b> fields.
                    </div>
                    <div>
                        <label for="label" class="form-label">Account Name</label>
                        <input type="text" name="edit_name" id="edit_name" class="form-control">
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="editRequireCredential" id="editRequireCredential">
                        <label class="form-check-label" for="formCheck1">
                            This account has own credentials
                        </label>
                    </div>
                    <div class="mt-2">
                        <label for="label" class="form-label">Username / Email Address</label>
                        <input type="text" name="edit_username" id="edit_username" class="form-control">
                    </div>
                    <div class="mt-2">
                        <label class="form-label" for="password">Password</label>

                        <div class="position-relative auth-pass-inputgroup">
                            <input name="edit_password" type="password" class="form-control pe-5 password-input" id="edit_password">
                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="editTogglePassword">
                                <i class="ri-eye-fill align-middle" id="editTogglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">
                        Leave blank to keep the current password. Enter a new password only if you want to change it.
                    </small>
                    <div class="mt-2">
                        <label for="label" class="form-label">Notes</label>
                        <input type="text" name="edit_notes" id="edit_notes" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="editAccountSubmit">Update Account</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div id="verifyAccountModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Verify Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('account.verify.password') }}" method="post" id="verifyAccountForm">
                @csrf
                <input type="hidden" name="verify_account_id" id="verify_account_id">
                <div class="modal-body">
                    <div class="col">
                        <h5 class="card-title" id="verifyAccountName">Helos</h5>
                        <p class="text-muted">Account Name</p>
                    </div>
                    <div class="col">
                        <h5 class="card-title" id="verifyAccountUsername">Helos</h5>
                        <p class="text-muted">Username / Email Address</p>
                    </div>
                    <hr>
                    <div class="alert alert-info material-shadow" role="alert">
                        Enter your <b>password</b> to verify.
                    </div>
                    <div class="mt-2">
                        <label class="form-label" for="password">Password</label>

                        <div class="position-relative auth-pass-inputgroup">
                            <input name="verify_password" type="password" class="form-control pe-5 password-input" id="verify_password">
                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="verifyTogglePassword">
                                <i class="ri-eye-fill align-middle" id="verifyTogglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="verifyAccountSubmit">Verify</button>
                </div>
            </form>

        </div>
    </div>
</div>