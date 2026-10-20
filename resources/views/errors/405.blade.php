<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>

    <meta charset="utf-8" />
    <title>AccountNimo | Forbidden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <script src="{{ asset('assets/js/velzon/layout.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/icons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/app.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/velzon/custom.min.css')}}">

</head>

<body>

    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5">
                        <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <lord-icon class="avatar-xl" src="{{ asset('assets/json/doodle-motif-1140-warning-triangle-hover-pinch.json')}}" trigger="loop" colors="primary:#405189,secondary:#0ab39c"></lord-icon>
                                    <h1 class="text-primary mb-4">Oops!</h1>
                                    <h4 class="text-uppercase">Method Not Allowed 😭</h4>
                                    <p class="text-muted mb-4">Please let us know what you were doing when this error occurred.</p>
                                    <a href="{{ route('index') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Back to home</a>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
    <script src="{{ asset('assets/js/velzon/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/waves.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/feather.min.js')}}"></script>
    <script src="{{ asset('assets/js/velzon/lord-icon-2.1.0.js')}}"></script>
</body>

</html>