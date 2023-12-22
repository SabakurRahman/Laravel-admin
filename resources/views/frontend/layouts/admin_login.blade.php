<!doctype html>
<html lang="en">

<head>
    @include('frontend.includes.head')
    <title> @yield('page_title')</title>
</head>
<style>
    .text-muted {
        color: #74788d !important;
    }
    label {
        margin-bottom: 0.5rem!important;
        color:#495057;
    }
    .btn-primary {
        color: #fff;
        background-color: #5867c3;
        border-color: #5867c3;
    }
    .form-control{
        font-size:0.8rem!important;

    }
</style>
<body class="auth-body-bg">
    <div class="home-btn d-none d-sm-block">
        <a href="{{route('front.index')}}"></a>
    </div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    @yield('content')
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </div>

     @include('frontend.includes.script')

</body>

</html>