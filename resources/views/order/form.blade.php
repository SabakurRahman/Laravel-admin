<div class="row">
            <div class="col-md-6">
                <div class="card quick-order-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Order Status </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('order_status', \App\Models\Order::ORDER_STATUS_LIST, null, ['class' => 'form-select', 'id' => 'order_status', 'placeholder' => 'Order Status']) !!}


                            </div>
                        </div>
                    </div>
                </div>
                <div class="card quick-order-card mb-4">
                    <div class="card-header">
                        <p>Customer Details</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Customer Name</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('customer_name', null, ['class' => 'form-control','id' => 'basicpill-firstname-input','placeholder' => 'Enter Customer Name']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Phone Number</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('phone_number', null, ['class' => 'form-control','id' => 'basicpill-firstname-input','placeholder' => 'Enter Phone Number']) !!}
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="example-date-input">Address</label>
                            </div>
                            <div class="col-md-8">

                              {!! Form::textarea('address', null, ['class' => 'form-control','id' => 'address','placeholder' => 'Enter Customer Name']) !!}


                            </div>
                        </div>


                    </div>
                </div>
                <div class="card quick-order-card mb-4">
                    <div class="card-header">
                        <p>Shipping And Courier Information</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="location">Shipping Method </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('order_status', \App\Models\Address::SHIPPING_METHOD, null, ['class' => 'form-select', 'id' => 'order_status','placeholder' => 'Shipping Method']) !!}
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="courier_id">Courier </label>
                            </div>
                            <div class="col-md-8">
                                <div class="d-none" id="courier_data" data-courier="[{&quot;id&quot;:1,&quot;courier_name&quot;:&quot;Sundorbon Courier LTD&quot;,&quot;inside_courier_charge&quot;:&quot;300&quot;,&quot;outside_courier_charge&quot;:&quot;500&quot;,&quot;inside_condition_charge&quot;:&quot;300&quot;,&quot;outside_condition_charge&quot;:&quot;1000&quot;,&quot;inside_return_charge&quot;:&quot;100&quot;,&quot;outside_return_charge&quot;:&quot;300&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-08-09T05:40:15.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-08-09T05:40:15.000000Z&quot;,&quot;zones&quot;:[],&quot;cities&quot;:[],&quot;divisions&quot;:[]},{&quot;id&quot;:2,&quot;courier_name&quot;:&quot;REDX&quot;,&quot;inside_courier_charge&quot;:&quot;111&quot;,&quot;outside_courier_charge&quot;:&quot;222&quot;,&quot;inside_condition_charge&quot;:&quot;111&quot;,&quot;outside_condition_charge&quot;:&quot;222&quot;,&quot;inside_return_charge&quot;:&quot;222&quot;,&quot;outside_return_charge&quot;:&quot;444&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-08-09T05:40:52.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-08-09T05:40:52.000000Z&quot;,&quot;zones&quot;:[],&quot;cities&quot;:[],&quot;divisions&quot;:[]},{&quot;id&quot;:8,&quot;courier_name&quot;:&quot;Janani Courier&quot;,&quot;inside_courier_charge&quot;:&quot;60&quot;,&quot;outside_courier_charge&quot;:&quot;120&quot;,&quot;inside_condition_charge&quot;:&quot;1&quot;,&quot;outside_condition_charge&quot;:&quot;1&quot;,&quot;inside_return_charge&quot;:&quot;1&quot;,&quot;outside_return_charge&quot;:&quot;50&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:28:32.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:37:26.000000Z&quot;,&quot;zones&quot;:[{&quot;id&quot;:11,&quot;name&quot;:&quot;Mirzapur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;zone_id&quot;:11}},{&quot;id&quot;:14,&quot;name&quot;:&quot;Gopalpur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;zone_id&quot;:14}},{&quot;id&quot;:8,&quot;name&quot;:&quot;Tangail Sadar&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;zone_id&quot;:8}}],&quot;cities&quot;:[{&quot;id&quot;:13,&quot;name&quot;:&quot;Tangail&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;city_id&quot;:13}}],&quot;divisions&quot;:[{&quot;id&quot;:1,&quot;name&quot;:&quot;Dhaka&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;division_id&quot;:1}}]},{&quot;id&quot;:9,&quot;courier_name&quot;:&quot;Steadfast&quot;,&quot;inside_courier_charge&quot;:&quot;60&quot;,&quot;outside_courier_charge&quot;:&quot;120&quot;,&quot;inside_condition_charge&quot;:&quot;0&quot;,&quot;outside_condition_charge&quot;:&quot;50&quot;,&quot;inside_return_charge&quot;:&quot;0&quot;,&quot;outside_return_charge&quot;:&quot;50&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:31:54.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:31:54.000000Z&quot;,&quot;zones&quot;:[{&quot;id&quot;:8,&quot;name&quot;:&quot;Tangail Sadar&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:8}},{&quot;id&quot;:9,&quot;name&quot;:&quot;Sakhipur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:46:21.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:46:21.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:9}},{&quot;id&quot;:10,&quot;name&quot;:&quot;Nagarpur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:46:43.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:46:43.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:10}},{&quot;id&quot;:11,&quot;name&quot;:&quot;Mirzapur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:11}},{&quot;id&quot;:12,&quot;name&quot;:&quot;Madhupur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:47:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:47:39.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:12}},{&quot;id&quot;:13,&quot;name&quot;:&quot;Kalihati Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:48:07.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:48:07.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:13}},{&quot;id&quot;:14,&quot;name&quot;:&quot;Gopalpur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:14}},{&quot;id&quot;:16,&quot;name&quot;:&quot;Ghatail Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:49:14.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:49:14.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:16}},{&quot;id&quot;:17,&quot;name&quot;:&quot;Dhanbari Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:50:02.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:50:02.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:17}},{&quot;id&quot;:18,&quot;name&quot;:&quot;Delduar Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:51:26.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:51:26.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:18}},{&quot;id&quot;:20,&quot;name&quot;:&quot;Bhuapur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:51:55.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:51:55.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:20}},{&quot;id&quot;:21,&quot;name&quot;:&quot;Basail Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:52:30.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:52:30.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:21}},{&quot;id&quot;:24,&quot;name&quot;:&quot;City corporation&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:19,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-21T09:34:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:34:25.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:24}},{&quot;id&quot;:23,&quot;name&quot;:&quot;City corporation&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:20,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-21T09:34:14.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:34:14.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:23}},{&quot;id&quot;:22,&quot;name&quot;:&quot;City corporation&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:21,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-21T09:33:46.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:33:46.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:22}},{&quot;id&quot;:25,&quot;name&quot;:&quot;Mirpur 1&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:22,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:35:06.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:35:06.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:25}},{&quot;id&quot;:26,&quot;name&quot;:&quot;Mohammadpur&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:22,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:35:21.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:35:21.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:26}}],&quot;cities&quot;:[{&quot;id&quot;:18,&quot;name&quot;:&quot;Shariatpur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:38:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:38:47.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:18}},{&quot;id&quot;:17,&quot;name&quot;:&quot;Rajbari&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:38:31.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:38:31.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:17}},{&quot;id&quot;:16,&quot;name&quot;:&quot;Madaripur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:38:12.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:38:12.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:16}},{&quot;id&quot;:15,&quot;name&quot;:&quot;Gopalganj&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:37:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:37:48.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:15}},{&quot;id&quot;:14,&quot;name&quot;:&quot;Faridpur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:37:17.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:37:17.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:14}},{&quot;id&quot;:13,&quot;name&quot;:&quot;Tangail&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:13}},{&quot;id&quot;:19,&quot;name&quot;:&quot;Rajshahi Sodar&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:32:37.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:32:37.000000Z&quot;,&quot;division_id&quot;:10,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:19}},{&quot;id&quot;:20,&quot;name&quot;:&quot;Rangpur Sodar&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:32:56.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:32:56.000000Z&quot;,&quot;division_id&quot;:9,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:20}},{&quot;id&quot;:21,&quot;name&quot;:&quot;Mymensingh Sodar&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:33:19.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:33:19.000000Z&quot;,&quot;division_id&quot;:7,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:21}},{&quot;id&quot;:22,&quot;name&quot;:&quot;Dhaka City&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:34:50.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:34:50.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:22}}],&quot;divisions&quot;:[{&quot;id&quot;:10,&quot;name&quot;:&quot;Rajshahi&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:30:56.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:30:56.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:10}},{&quot;id&quot;:9,&quot;name&quot;:&quot;Rangpur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-04T18:04:04.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:30:07.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:9}},{&quot;id&quot;:7,&quot;name&quot;:&quot;Mymensingh&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-08-24T12:12:59.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-08-24T12:22:58.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:7}},{&quot;id&quot;:1,&quot;name&quot;:&quot;Dhaka&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:1}}]}]"></div>
                                {!! Form::select('courier_id', [], null, ['class' => 'form-select', 'id' => 'courier_id']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Division </label>
                            </div>
                            <div class="col-md-8" data-division="">
                                {!! Form::select('division_id', [], null, ['class' => 'form-select', 'id' => 'division_select']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">City</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('city_id', ['' => 'Select City'], null, ['class' => 'form-select select2', 'id' => 'city_select', 'disabled' => 'disabled']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Zone </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('zone_id', ['' => 'Select Zone'], null, ['class' => 'form-select select2', 'id' => 'zone_select', 'disabled' => 'disabled']) !!}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card quick-order-card mb-4">
                    <div class="card-header">
                        <p>Billing Information</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="location">Shipping Method </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('order_status', \App\Models\Address::SHIPPING_METHOD, null, ['class' => 'form-select', 'id' => 'order_status']) !!}
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="courier_id">Courier </label>
                            </div>
                            <div class="col-md-8">
                                <div class="d-none" id="courier_data" data-courier="[{&quot;id&quot;:1,&quot;courier_name&quot;:&quot;Sundorbon Courier LTD&quot;,&quot;inside_courier_charge&quot;:&quot;300&quot;,&quot;outside_courier_charge&quot;:&quot;500&quot;,&quot;inside_condition_charge&quot;:&quot;300&quot;,&quot;outside_condition_charge&quot;:&quot;1000&quot;,&quot;inside_return_charge&quot;:&quot;100&quot;,&quot;outside_return_charge&quot;:&quot;300&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-08-09T05:40:15.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-08-09T05:40:15.000000Z&quot;,&quot;zones&quot;:[],&quot;cities&quot;:[],&quot;divisions&quot;:[]},{&quot;id&quot;:2,&quot;courier_name&quot;:&quot;REDX&quot;,&quot;inside_courier_charge&quot;:&quot;111&quot;,&quot;outside_courier_charge&quot;:&quot;222&quot;,&quot;inside_condition_charge&quot;:&quot;111&quot;,&quot;outside_condition_charge&quot;:&quot;222&quot;,&quot;inside_return_charge&quot;:&quot;222&quot;,&quot;outside_return_charge&quot;:&quot;444&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-08-09T05:40:52.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-08-09T05:40:52.000000Z&quot;,&quot;zones&quot;:[],&quot;cities&quot;:[],&quot;divisions&quot;:[]},{&quot;id&quot;:8,&quot;courier_name&quot;:&quot;Janani Courier&quot;,&quot;inside_courier_charge&quot;:&quot;60&quot;,&quot;outside_courier_charge&quot;:&quot;120&quot;,&quot;inside_condition_charge&quot;:&quot;1&quot;,&quot;outside_condition_charge&quot;:&quot;1&quot;,&quot;inside_return_charge&quot;:&quot;1&quot;,&quot;outside_return_charge&quot;:&quot;50&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:28:32.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:37:26.000000Z&quot;,&quot;zones&quot;:[{&quot;id&quot;:11,&quot;name&quot;:&quot;Mirzapur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;zone_id&quot;:11}},{&quot;id&quot;:14,&quot;name&quot;:&quot;Gopalpur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;zone_id&quot;:14}},{&quot;id&quot;:8,&quot;name&quot;:&quot;Tangail Sadar&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;zone_id&quot;:8}}],&quot;cities&quot;:[{&quot;id&quot;:13,&quot;name&quot;:&quot;Tangail&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;city_id&quot;:13}}],&quot;divisions&quot;:[{&quot;id&quot;:1,&quot;name&quot;:&quot;Dhaka&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:8,&quot;division_id&quot;:1}}]},{&quot;id&quot;:9,&quot;courier_name&quot;:&quot;Steadfast&quot;,&quot;inside_courier_charge&quot;:&quot;60&quot;,&quot;outside_courier_charge&quot;:&quot;120&quot;,&quot;inside_condition_charge&quot;:&quot;0&quot;,&quot;outside_condition_charge&quot;:&quot;50&quot;,&quot;inside_return_charge&quot;:&quot;0&quot;,&quot;outside_return_charge&quot;:&quot;50&quot;,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:31:54.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:31:54.000000Z&quot;,&quot;zones&quot;:[{&quot;id&quot;:8,&quot;name&quot;:&quot;Tangail Sadar&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:42:47.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:8}},{&quot;id&quot;:9,&quot;name&quot;:&quot;Sakhipur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:46:21.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:46:21.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:9}},{&quot;id&quot;:10,&quot;name&quot;:&quot;Nagarpur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:46:43.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:46:43.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:10}},{&quot;id&quot;:11,&quot;name&quot;:&quot;Mirzapur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:47:09.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:11}},{&quot;id&quot;:12,&quot;name&quot;:&quot;Madhupur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:47:39.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:47:39.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:12}},{&quot;id&quot;:13,&quot;name&quot;:&quot;Kalihati Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:48:07.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:48:07.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:13}},{&quot;id&quot;:14,&quot;name&quot;:&quot;Gopalpur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:48:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:14}},{&quot;id&quot;:16,&quot;name&quot;:&quot;Ghatail Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:49:14.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:49:14.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:16}},{&quot;id&quot;:17,&quot;name&quot;:&quot;Dhanbari Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:50:02.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:50:02.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:17}},{&quot;id&quot;:18,&quot;name&quot;:&quot;Delduar Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:51:26.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:51:26.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:18}},{&quot;id&quot;:20,&quot;name&quot;:&quot;Bhuapur Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:51:55.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:51:55.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:20}},{&quot;id&quot;:21,&quot;name&quot;:&quot;Basail Upazila&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:13,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-05T04:52:30.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:52:30.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:21}},{&quot;id&quot;:24,&quot;name&quot;:&quot;City corporation&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:19,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-21T09:34:25.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:34:25.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:24}},{&quot;id&quot;:23,&quot;name&quot;:&quot;City corporation&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:20,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-21T09:34:14.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:34:14.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:23}},{&quot;id&quot;:22,&quot;name&quot;:&quot;City corporation&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:21,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:0,&quot;created_at&quot;:&quot;2023-09-21T09:33:46.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:33:46.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:22}},{&quot;id&quot;:25,&quot;name&quot;:&quot;Mirpur 1&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:22,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:35:06.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:35:06.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:25}},{&quot;id&quot;:26,&quot;name&quot;:&quot;Mohammadpur&quot;,&quot;name_bn&quot;:null,&quot;city_id&quot;:22,&quot;status&quot;:1,&quot;is_inside_dhaka&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:35:21.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:35:21.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;zone_id&quot;:26}}],&quot;cities&quot;:[{&quot;id&quot;:18,&quot;name&quot;:&quot;Shariatpur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:38:47.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:38:47.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:18}},{&quot;id&quot;:17,&quot;name&quot;:&quot;Rajbari&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:38:31.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:38:31.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:17}},{&quot;id&quot;:16,&quot;name&quot;:&quot;Madaripur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:38:12.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:38:12.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:16}},{&quot;id&quot;:15,&quot;name&quot;:&quot;Gopalganj&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:37:48.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:37:48.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:15}},{&quot;id&quot;:14,&quot;name&quot;:&quot;Faridpur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:37:17.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:37:17.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:14}},{&quot;id&quot;:13,&quot;name&quot;:&quot;Tangail&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:36:55.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:13}},{&quot;id&quot;:19,&quot;name&quot;:&quot;Rajshahi Sodar&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:32:37.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:32:37.000000Z&quot;,&quot;division_id&quot;:10,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:19}},{&quot;id&quot;:20,&quot;name&quot;:&quot;Rangpur Sodar&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:32:56.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:32:56.000000Z&quot;,&quot;division_id&quot;:9,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:20}},{&quot;id&quot;:21,&quot;name&quot;:&quot;Mymensingh Sodar&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:33:19.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:33:19.000000Z&quot;,&quot;division_id&quot;:7,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:21}},{&quot;id&quot;:22,&quot;name&quot;:&quot;Dhaka City&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-21T09:34:50.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-21T09:34:50.000000Z&quot;,&quot;division_id&quot;:1,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;city_id&quot;:22}}],&quot;divisions&quot;:[{&quot;id&quot;:10,&quot;name&quot;:&quot;Rajshahi&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-05T04:30:56.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:30:56.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:10}},{&quot;id&quot;:9,&quot;name&quot;:&quot;Rangpur&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-09-04T18:04:04.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-09-05T04:30:07.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:9}},{&quot;id&quot;:7,&quot;name&quot;:&quot;Mymensingh&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-08-24T12:12:59.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-08-24T12:22:58.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:7}},{&quot;id&quot;:1,&quot;name&quot;:&quot;Dhaka&quot;,&quot;name_bn&quot;:null,&quot;status&quot;:1,&quot;created_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;updated_at&quot;:&quot;2023-07-17T06:42:44.000000Z&quot;,&quot;pivot&quot;:{&quot;courier_id&quot;:9,&quot;division_id&quot;:1}}]}]"></div>
                                {!! Form::select('courier_id', [], null, ['class' => 'form-select', 'id' => 'courier_id']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Division </label>
                            </div>
                            <div class="col-md-8" data-division="">
                                {!! Form::select('division_id', [], null, ['class' => 'form-select', 'id' => 'division_select']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">City</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('city_id', ['' => 'Select City'], null, ['class' => 'form-select select2', 'id' => 'city_select', 'disabled' => 'disabled']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Zone </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('zone_id', ['' => 'Select Zone'], null, ['class' => 'form-select select2', 'id' => 'zone_select', 'disabled' => 'disabled']) !!}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card quick-order-card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center mb-2">

                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Order Date </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::date('order_date', null, ['class' => 'form-control', 'id' => 'order_date']) !!}

{{--                                <input id="order_time" value="2023-09-26 16:42:41" name="order_time"--}}
{{--                                       type="datetime-local" class=" form-control">--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card quick-order-card mb-4">
                    <div class="card-header">
                        <p>Product Info</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Product</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('product_id',collect($data['product'])->pluck('title', 'id'), null, ['class' => 'form-select select2', 'id' => 'product_id']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Quantity</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::number('quantity', null, ['class' => 'form-control', 'id' => 'quantity', 'placeholder' => 'Enter Quantity']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Unit Price</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::number('unit_price', null, ['class' => 'form-control', 'id' => 'unit_price', 'placeholder' => 'Enter Unit Price']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="basicpill-firstname-input">Amount</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::number('amount', null, ['class' => 'form-control', 'id' => 'amount', 'placeholder' => 'Enter Amount']) !!}

                            </div>
                        </div>
                        <div id="variation_attribute_area"></div>

                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <button type="button" id="add_product" class="btn btn-sm btn-success">Add Product</button>
                            </div>
                        </div>

                        <div class="row align-items-center my-3">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Amount</th>
                                    <th style="width: 150px">Attributes</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody id="product_list">

                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <p>Add payment details</p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="payment_method_id"> Payment Type</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('payment_method_id',[], null, ['class' => 'form-select select2', 'id' => 'payment_method_id']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="payment_account"> Payment </label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::select('payment_account',[], null, ['class' => 'form-select select2', 'id' => 'payment_account']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="sender_number">Sender Number</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('sender_account_no', null, ['class' => 'form-control', 'id' => 'sender_number', 'placeholder' => 'Enter Sender Number']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="trx_id">Trx ID</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('trx_id', null, ['class' => 'form-control', 'id' => 'trx_id', 'placeholder' => 'Enter Transaction ID']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="paid_amount">Amount</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::text('paid_amount', null, ['class' => 'form-control', 'id' => 'paid_amount', 'placeholder' => 'Enter amount']) !!}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <p>Payment Overview </p>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-2">


                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="sub_total">Sub Total</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::number('sub_total', null, ['class' => 'form-control', 'id' => 'sub_total', 'placeholder' => 'Enter Sub Total', 'readonly' => true]) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="delivery_charge">Delivery</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::number('delivery_charge', null, ['class' => 'form-control', 'id' => 'delivery_charge', 'placeholder' => 'Enter Delivery Charge']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="discount">Discount</label>
                            </div>
                            <div class="col-md-8">

                                {!! Form::number('discount', null, ['class' => 'form-control', 'id' => 'discount', 'placeholder' => 'Enter Discount']) !!}

                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="payment">Paid</label>
                            </div>
                            <div class="col-md-8">
                                <p id="paid_amount"
                                   class="form-control text-success">0</p>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="total">Condition</label>
                            </div>
                            <div class="col-md-8">
                                {!! Form::number('total', null, ['class' => 'form-control', 'id' => 'total', 'placeholder' => 'Enter condition amount']) !!}

                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-12">
                <div class="card quick-order-card">
                    <div class="card-header">
                        <p>Order Note</p>
                    </div>
                    <div class="card-body">
                        {!! Form::textarea('comment', null, ['class' => 'form-control', 'id' => 'comment']) !!}

                    </div>
                </div>
            </div>
            <input type="hidden" id="selected_products" name="selected_products">

        </div>


