<div id="addLinkModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('account.link.store') }}" method="post" id="addAccountLinkForm">
                @csrf
                <input type="hidden" name="account_id" id="account_id">
                <div class="modal-body">
                    <div class="alert alert-info material-shadow" role="alert">
                        Select an account and specify how it is linked.
                    </div>
                    <label for="linked_account_id" class="form-label"> Linked Account </label>
                    <select name="linked_account_id" id="linked_account_id" class="form-control">
                        <option value="" disabled selected>Select an account</option>
                        @foreach ($availableAccounts as $linkedAccount)
                            <option value="{{ $linkedAccount->id }}">
                                {{ $linkedAccount->name }}
                                @if ($linkedAccount->username)
                                    ({{ $linkedAccount->username }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <label class="form-label">Link Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="link_type" id="link_type_login_via" value="login_via">
                            <label class="form-check-label" for="link_type_login_via"> Login Via </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="link_type" id="link_type_registered_with" value="registered_with">
                            <label class="form-check-label" for="link_type_registered_with"> Registered With </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="addAccountLinkSubmit">Add Link</button>
                </div>
            </form>

        </div>
    </div>
</div>