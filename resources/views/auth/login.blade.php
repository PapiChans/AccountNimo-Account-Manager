<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AccountNimo | Login</title>
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
                                <a href="{{ route('login' )}}" class="d-inline-block auth-logo">
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
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Start Managing your Accounts.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="index.html">

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">Log In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Register </a> </p>
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
                            <p class="mb-0 text-muted">
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
</html>