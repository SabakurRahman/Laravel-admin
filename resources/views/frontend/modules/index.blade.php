@extends('frontend.layouts.master')
<style>
    .card-size{
        height:140px!important;
        border-radius: 10px!important;
    }
    .customer{
        background-image: linear-gradient(to bottom right, #775DD0, rgb(202, 179, 179));   
    }
    .month{
        background-color:#317773 !important;
    }
    .order{
        background-color:#E0A96D !important;
    }
    .sale{
        background-color:#F1AC88 !important;
    }
    .btn-style{
        width:100%;
    }
    .text-style{
        font-size: 26px;
        font-weight: 600;
        color: white!important;
    }
    .text-style:hover{
        color: rgba(255, 255, 255, 0.632)!important;
    }
    .icon-size{
        font-size:25px!important;
    }
    .icon-size-customer{
        font-size:18px!important;
    }
    .card-size .card-body h5{
        border-bottom:1.5px solid whitesmoke;
        opacity:0.8;
    }
</style>
{{-- @section('page_title','Welcome') --}}
@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div style="margin-bottom:20px"class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Aabash</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        {{-- customer,month,order, sales boxes --}}
        <div style="margin-bottom:20px"class="row">
                    <div class="col-lg-3">
                        <div class="card card-size customer text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                    <i class="mb-2 fa-solid fa-user-group icon-size-customer"></i>
                                    Total Customer
                                </h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">91</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="card card-size month text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                    <i class="text-white ri-file-list-line icon-size"></i>
                                    Monthly sold
                                </h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">100</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-3">
                        <div class="card order card-size text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                    <i style="margin-right:5px"class="ri-truck-line icon-size"></i>Total Order
                                </h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">520</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-3">
                        <div class="card sale card-size text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                    <i class="ri-bar-chart-grouped-line icon-size"></i>
                                   Total Sales</h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">420</span></a>
                            </div>
                        </div>
                    </div>
        </div>
        {{--Sales By Data chart --}}
        <div style="margin-bottom:20px" class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div style="background-color:#e9e59d"class="card-head">
                         <h4 style="text-align:center"class="my-2 card-title">Sales By Data</h4>
                    </div>
                    <div class="card-body">
                        <div id="sales_by_date" class="apex-charts" dir="ltr"></div>                              
                    </div>
                </div>
            </div>
        </div>
         {{--Top Customer chart --}}
        <div style="margin-bottom:20px" class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div style="background-color:#e9e59d"class="card-head">
                         <h4 style="text-align:center"class="my-2 card-title">Top Customers</h4>
                    </div>
                    <div class="card-body">
                        <div id="top_customers" class="apex-charts" dir="ltr"></div>                              
                    </div>
                </div>
            </div>
        </div>
        {{--Top product chart --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div style="background-color:#e9e59d"class="card-head">
                         <h4 style="text-align:center"class="my-2 card-title">Top Products</h4>
                    </div>
                    <div class="card-body">
                        <div id="top_product" class="apex-charts" dir="ltr"></div>                              
                    </div>
                </div>
            </div>
        </div>

        {{-- amount,discount,net amount ,stock--}}
        <div style="margin-top:20px"class="row">
                    <div class="col-lg-3">
                        <div class="card card-size customer text-white-50">
                            <div class="card-body">
                                 <h5 class="mt-0 mb-2 text-white">
                                    <i class="text-white ri-coins-line icon-size"></i>
                                    Total Amount
                                </h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">90475272</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="card card-size month text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                    <i class="text-white ri-percent-line icon-size"></i>
                                    Total Discount
                                </h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">172750</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-3">
                        <div class="card order card-size text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                    <i class="mb-1 fa-solid fa-bangladeshi-taka-sign icon-size"></i>
                                    Net Amount
                                </h5>
                                <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">5415172</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-3">
                        <div class="card sale card-size text-white-50">
                            <div class="card-body">
                                <h5 class="mt-0 mb-2 text-white">
                                 <i class="ri-stock-line icon-size"></i>
                                Total Stock</h5>
                                <div>
                                    <a href="#" class="btn btn-default btn-style waves-effect waves-light">
                                    <span class="text-style">2727817</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>


    </div>
@endsection