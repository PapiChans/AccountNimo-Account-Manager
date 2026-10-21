@extends('master.master')
@section('content')
@include('account.modal.account_modal')
<div class="card card-body">
    <div class="row d-flex align-items-center">
        <div class="col-12 col-md-6 text-start">
            <h4 class="card-title">Manage Accounts</h4>
        </div>
        <div class="col-12 col-md-6 justify-content-end text-end">
            <a href="{{ route('categories.index', $vaultID)}}" class="btn btn-info">Back</a>
            @if (!$accounts->isEmpty()) 
                <button class="btn btn-primary" onclick="showAddAccount({{$categoryID}})">Create Account</button>
            @endif
        </div>
    </div>
</div>
@if ($accounts->isEmpty()) 
<div class="card card-body text-center">
    <div class="avatar-sm mx-auto mb-3">
        <div class="avatar-title bg-success-subtle text-success fs-17 rounded">
            <i class="ri-add-line"></i>
        </div>
    </div>
    <h4 class="card-title">Please add new account</h4>
    <p class="card-text text-muted">You have no account at this moment. Please add a new one.</p>
    <button class="btn btn-success" onclick="showAddAccount({{$categoryID}})">Add Account</button>
</div>
@else
<div class="card card-body">
    <div class="table table-responsive">
        <table id="myTable" class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Notes</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->username ? $item->username : 'Not Available'}}</td>
                    <td>{{$item->password_mask ? $item->password_mask : 'Not Available'}}</td>
                    <td>{{$item->notes ? $item->notes: 'N/A'}}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">

                            @if ($item->password_mask || $item->password_hash)    
                                <button type="button" onclick="showVerifyAccount({{$item->id}}, `{{$item->name}}`, `{{$item->username}}`)"
                                    class="btn btn-success btn-icon waves-effect waves-light"
                                    title="Verify">
                                    <i class="ri-check-line"></i>
                                </button>
                            @endif


                            <button type="button"
                                class="btn btn-primary btn-icon waves-effect waves-light"
                                title="Links">
                                <i class="ri-link"></i>
                            </button>

                            <button type="button" onclick="showEditAccount({{$item->id}}, `{{$item->name}}`, `{{$item->username}}`, `{{$item->password_mask}}`)"
                                class="btn btn-info btn-icon waves-effect waves-light"
                                title="Edit">
                                <i class="ri-edit-line"></i>
                            </button>

                            <button type="button" onclick="deleteAccount({{$item->id}})"
                                class="btn btn-danger btn-icon waves-effect waves-light"
                                title="Moved to Trash">
                                <i class="ri-delete-bin-5-line"></i>
                            </button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@push('scripts')
    <script>

        function showAddAccount(categoryID) {
            $('#addAccountForm')[0].reset();
            // Disable Fields
            $('#username').prop('disabled', true);
            $('#password').prop('disabled', true);

            $('#category_id').val(categoryID);
            $('#addAccountModal').modal('show');
        }

        $('#addRequireCredential').change(function (){
            $('#username').prop('disabled', !this.checked);
            $('#password').prop('disabled', !this.checked);
        });

        $('#addAccountForm').validate({

            rules: {

                name: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                },  

                username: {
                    required: "#addRequireCredential:checked",
                    minlength: 6,
                    maxlength: 30,
                },  

                password: {
                    required: "#addRequireCredential:checked",
                    minlength: 6,
                    maxlength: 30,
                },  

                notes: {
                    maxlength: 20,
                },  

            },

            messages: {

                name: {
                    required: "Name is required"
                },

                username: {
                    required: "Username is required when credentials are enabled"
                },
                
                password: {
                    required: "Password is required when credentials are enabled"
                }

            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },

            submitHandler: function (form) {
                // alert('Validation Passed');

                Swal.fire({
                title: "Add Account?",
                text: "This will add to the records",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#88dd33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, add account!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addAccountSubmit').text('Submitting...')
                        $('#addAccountSubmit').prop('disabled', true)
                        form.submit();
                    }
                });
            }
        });

        function deleteAccount(id) {

            let url = "{{ route('account.delete', ':id')}}";
            url = url.replace(':id', id);

            Swal.fire({
            title: "Delete Account?",
            text: "This account are moved to trash.",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting Account...',
                        text: 'Please wait for a while.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 0,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == 'success'){
                                Swal.fire({
                                    title: "Success!",
                                    text: "Account Deleted successfully!",
                                    icon: "success"
                                }).then((result) => {
                                    if(result.isConfirmed)
                                    {
                                        location.reload();
                                    }
                                });
                            }
                            else {
                                Swal.fire({
                                    title: "Conflict!",
                                    text: response.text,
                                    icon: "error"
                                })
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            toastr.error('Something went wrong', 'Internal Server Error');
                        }
                    });
                }
            });
        }

        $(document).on('click', '#addTogglePassword', function () {
            const passwordInput = $('#password');
            const passwordIcon = $('#addTogglePasswordIcon');

            const isPassword = passwordInput.attr('type') === 'password';

            passwordInput.attr('type', isPassword ? 'text' : 'password');

            passwordIcon
                .toggleClass('ri-eye-fill', !isPassword)
                .toggleClass('ri-eye-off-fill', isPassword);
        });

        function showEditAccount(accountID, name, username, password) {
            $('#editAccountForm')[0].reset();

            if (username || password)
            {
                $('#editRequireCredential').prop('checked', true);
                $('#edit_username').prop('disabled', false);
                $('#edit_username').val(username);
                $('#edit_password').prop('disabled', false);
            }
            else {
                // Disable Fields
                $('#edit_username').prop('disabled', true);
                $('#edit_password').prop('disabled', true);
            }

            $('#edit_name').val(name);
            $('#edit_id').val(accountID);
            $('#editAccountModal').modal('show');
        }

        $('#editRequireCredential').change(function (){
            $('#edit_username').prop('disabled', !this.checked);
            $('#edit_password').prop('disabled', !this.checked);
        });

        $(document).on('click', '#editTogglePassword', function () {
            const passwordInput = $('#edit_password');
            const passwordIcon = $('#editTogglePasswordIcon');

            const isPassword = passwordInput.attr('type') === 'password';

            passwordInput.attr('type', isPassword ? 'text' : 'password');

            passwordIcon
                .toggleClass('ri-eye-fill', !isPassword)
                .toggleClass('ri-eye-off-fill', isPassword);
        });

        $('#editAccountForm').validate({

            rules: {

                edit_name: {
                    required: true,
                    minlength: 6,
                    maxlength: 20,
                },  

                edit_username: {
                    required: "#editRequireCredential:checked",
                    minlength: 6,
                    maxlength: 30,
                },  

                edit_password: {
                    minlength: 6,
                    maxlength: 30,
                },  

                edit_notes: {
                    maxlength: 20,
                },  

            },

            messages: {

                edit_name: {
                    required: "Name is required"
                },

                edit_username: {
                    required: "Username is required when credentials are enabled"
                },

            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },

            submitHandler: function (form) {
                // alert('Validation Passed');

                Swal.fire({
                title: "Update Account?",
                text: "This will update to the records",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#88dd33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, update account!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#editAccountSubmit').text('Updating...')
                        $('#editAccountSubmit').prop('disabled', true)
                        form.submit();
                    }
                });
            }
        });

        function showVerifyAccount(accountID, name, username) {
            $('#verifyAccountForm')[0].reset();

            $('#verify_account_id').val(accountID);
            $('#verifyAccountName').text(name);
            $('#verifyAccountUsername').text(username);
            $('#verifyAccountModal').modal('show');
        }

        $(document).on('click', '#verifyTogglePassword', function () {
            const passwordInput = $('#verify_password');
            const passwordIcon = $('#verifyTogglePasswordIcon');

            const isPassword = passwordInput.attr('type') === 'password';

            passwordInput.attr('type', isPassword ? 'text' : 'password');

            passwordIcon
                .toggleClass('ri-eye-fill', !isPassword)
                .toggleClass('ri-eye-off-fill', isPassword);
        });

        $('#verifyAccountForm').validate({
            rules: {
                verify_password: {
                    required: true,
                },
            },

            messages: {
                verify_password: {
                    required: 'Password is required.',
                },
            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.auth-pass-inputgroup'));
            },

            submitHandler: function (form) {
                const submitButton = $('#verifyAccountSubmit');

                submitButton
                    .text('Verifying...')
                    .prop('disabled', true);

                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',

                    success: function (response) {
                        Swal.fire({
                            title: response.verified
                                ? 'Password Verified!'
                                : 'Verification Failed',

                            text: response.message,

                            icon: response.verified
                                ? 'success'
                                : 'error',

                            confirmButtonText: 'OK',
                        });
                    },

                    error: function (xhr) {
                        let message = 'Something went wrong. Please try again.';

                        if (xhr.status === 422) {
                            message = xhr.responseJSON?.message
                                || 'Please check the submitted information.';
                        } else if (xhr.status === 403) {
                            message = 'You are not authorized to verify this account.';
                        }

                        Swal.fire({
                            title: 'Error',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    },

                    complete: function () {
                        submitButton.text('Verify').prop('disabled', false);
                    },
                });

                return false;
            },
        });

        $(document).ready(function () {
            const table = new DataTable('#myTable', {
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": [-1],
                    }
                ],
                responsive: true,
            });
        });
    </script>
@endpush
@endsection