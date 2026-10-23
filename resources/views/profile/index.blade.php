@extends('master.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Change Name</h5>
        <form action="{{ route('profile.updateName') }}" method="POST" id="updateProfileNameForm">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="label" class="form-label">Profile Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
                </div>
                <div class="col-12 col-md-6 d-flex align-items-end justify-content-end justify-content-md-start mt-2">
                    <button class="btn btn-primary" type="submit" id="updateNameButton">Update name</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title">Change Password</h5>
        <form action="{{ route('profile.changePassword') }}" method="POST" id="changePasswordForm">
            @csrf
                <div class="col-12 col-md-6">
                    <label for="label" class="form-label">Old Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control">
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="label" class="form-label">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control">
                </div>
                <div class="col-12 col-md-6 mt-2">
                    <label for="label" class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control">
                </div>
                <div class="col-12 d-flex align-items-end justify-content-end justify-content-md-start mt-2">
                    <button class="btn btn-primary" type="submit" id="changePasswordButton">Change Password</button>
                </div>
        </form>
    </div>
</div>
@push('scripts')
    <script>

        $('#updateProfileNameForm').validate({

            rules: {

                name: {
                    required: true,
                    minlength: 10,
                    maxlength: 20,
                },

            },

            messages: {

                name: {
                    required: "Name is required"
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
                title: "Update Name?",
                text: "This will update your name to the records",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#88dd33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, update Name!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#updateNameButton').text('Submitting...')
                        $('#updateNameButton').prop('disabled', true)
                        form.submit();
                    }
                });
            }
        });

        $('#changePasswordForm').validate({

            rules: {
                old_password: {
                    required: true,
                    minlength: 6,

                    remote: {
                        url: "{{ route('profile.checkOldPassword') }}",
                        type: "POST",
                        data: {
                            old_password: function () {
                                return $('#old_password').val();
                            },
                            _token: "{{ csrf_token() }}"
                        }
                    }
                },

                new_password: {
                    required: true,
                    minlength: 6
                },

                confirm_new_password: {
                    required: true,
                    minlength: 6,
                    equalTo: '#new_password'
                }
            },

            messages: {
                old_password: {
                    required: 'Please enter your old password',
                    minlength: 'Password must be at least 6 characters',
                    remote: 'Your old password is incorrect',
                },

                new_password: {
                    required: 'Please enter your new password',
                    minlength: 'Password must be at least 6 characters'
                },

                confirm_new_password: {
                    required: 'Please confirm your new password',
                    minlength: 'Password must be at least 6 characters',
                    equalTo: 'Passwords do not match'
                }
            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',

            highlight: function(element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },

            submitHandler: function(form) {

                Swal.fire({
                    title: 'Change Password?',
                    text: 'Are you sure you want to change your password?',
                    icon: 'question',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: true,
                    confirmButtonColor: '#88dd33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, change password!'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $('#changePasswordButton')
                            .prop('disabled', true)
                            .text('Changing Password...');

                        form.submit();
                    }

                });
            }
        });

        $(document).ready(function () {

        });
    </script>
@endpush
@endsection