<!doctype html>
<html lang="en">

<head>
    @include('frontend.includes.head')

</head>


<body style="background:#dcd7d72e;">

<div id="layout-wrapper">


    <header id="page-topbar">
        @include('frontend.includes.header')
    </header>
    <!-- Header done -->

    <!-- === Left Sidebar Start ========== -->
    @include('frontend.includes.left_side_bar')
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card mb-2">
                    <div class="card-body">
                        @include('global_partials.breadcrumb')
                        {{--@include('global_partials.page_title_and_button')--}}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @include('global_partials.flash')
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- @include('frontend.includes.footer') -->
        </div>
    </div>


    {{--        <div class="main-content " style="margin-top:100px ">--}}

    {{--            @yield('content')--}}

    {{--            @include('frontend.includes.footer')--}}

    {{--        </div>--}}
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
@include('frontend.includes.right_side_bar')

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- script -->
@include('frontend.includes.script')


</body>

</html>
