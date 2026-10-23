<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AccountNimo | Register</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <script src="{{ asset('assets/js/velzon/layout.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/icons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/app.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/custom.min.css')}}">
</head>
<body>
<div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="{{ route('register' )}}" class="d-inline-block auth-logo">
                                    <img src="{{ asset('assets/images/favicon.ico')}} " alt="" height="60">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">AccountNimo - Account Manager</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Create New Account</h5>
                                    <p class="text-muted">Get your free account now</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form id="registerForm" class="needs-validation" method="POST" action="{{ route('register.store') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="user" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="account_username" id="account_username" placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" name="password" id="password" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>  
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit" id="submitButton">Register</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Log In </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                2026 AccountNimo - Created by PapiChans
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
</body>
    <script src="{{ asset('assets/js/velzon/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/waves.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/feather.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/lord-icon-2.1.0.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/particles.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/particales.app.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/password-addon.init.js')}}"></script>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/libs/jquery/jquery.validate.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#registerForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 10,
                        maxlength: 30,
                    },


                    email: {
                        required: true,
                        email: true,

                        remote: {
                            url: "{{ route('register.checkEmail') }}",
                            type: "POST",
                            data: {
                                email: function () {
                                    return $('#email').val();
                                },
                                _token: "{{ csrf_token() }}"
                            }
                        }
                    },

                    account_username: {
                        required: true,
                        minlength: 8,

                        remote: {
                            url: "{{ route('register.checkUsername') }}",
                            type: "POST",
                            data: {
                                account_username: function () {
                                    return $('#account_username').val();
                                },
                                _token: "{{ csrf_token() }}"
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },

                messages: {
                    name: {
                        required: 'Please enter your name',
                        minlength: 'Name is required to be long up to at least 10 characters'
                    },

                    account_username: {
                        required: 'Please enter your username',
                        minlength: 'Username must be at least 8 characters',
                        remote: "Username already exists",
                    },

                    email: {
                        required: "Email address is required",
                        email: "Please enter a valid email",
                        remote: "Email already exists"
                    },


                    password: {
                        required: 'Please enter your password',
                        minlength: 'Password must be at least 6 characters'
                    }
                },

                errorElement: 'span',

                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.mb-3, .mb-2').append(error);
                },

                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },

                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },

                submitHandler: function(form) {

                    // disable button
                    $('#submitButton').prop('disabled', true).text('Creating new account...');

                    form.submit();
                }
            });
        });
    </script>
</html>