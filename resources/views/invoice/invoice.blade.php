<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.includes.head')

</head>
<style>
    .title-style{
        padding-left:10px!important;
        background:#dcd7d72e!important;
        border-radius: 3px!important;
    }
    .card-customize-style{
        box-shadow: 0 0 7px #e3e3e3 !important;
    }
    .title-span{
        color:#636161!important;
        font-family:Inter;
        font-weight: 700;
        font-size: 14px;
    }
    .data-style{
        padding-left:10px!important;
        color:#636161!important;
        font-family:Inter;
        font-weight: 600;
        font-size: 13px;
        border-style: none!important;
    }
    .head-title-style{
        font-family: 'Inter'!important;
        color: #575757!important;
        font-weight: 700!important;
    }
</style>
<body>
{{-- <body style="background:#dcd7d72e;"> --}}

<div style="background:#dcd7d72e;padding:5px;"class="row">
    <h3 class="text-center head-title-style">INVOICE</h3>
</div>
<div class="invoice-body" style="height: 7.4in; padding: 5px 0.25in 0.25in; margin-bottom: .25in;">
    <div class="row">
        <table class="table table-borderless">
            <tbody>
            <tr>
                <td>
                    <h6 style="font-size: 16px"><b>Order#</b></h6>
                    {{-- <h6 style="font-size: 16px"><b>Order# {{$order->invoice_no}}</b></h6> --}}
                    <h6 style="font-size: 16px"><b>http://www.aabash.com</b></h6>
                </td>
                <td style="text-align: right">
                    <img style="margin-bottom:3px"src="https://abaash-frontend.1putym.easypanel.host/_next/image?url=%2Fimages%2Flogo_abaash.png&w=1920&q=75" alt="company-logo"
                         width="180px"height="40px">
                    <div class="address">
                        <p>House 14 , Block# B , Banasree , Dhaka-1219</p>
                        <p>Phone: +88 01844 505 504</p>
                        <p>Email: info@aabash.com</p>
                    </div>
                </td>
            </tr>

            {{-- <tr>
                <td>
                    <div class="shipment-address" style="text-align: left">
                        <p><strong>Customer Information:</strong></p>
                        <p>Name: {{$order->user?->name}}</p>
                        <p>Phone: {{ $order?->shipping_address?->phone }}</p>
                        <p>
                            Address: {{ $order?->shipping_address?->street_address }}
                            {{ $order?->shipping_address?->zone?->name }}
                            {{ $order?->shipping_address?->city?->name }}
                            {{ $order?->shipping_address?->divition?->name }}
                            {{ $order?->shipping_address?->zip_code }}
                            {{ $order?->shipping_address?->landmark }}
                        </p>
                    </div>
                </td>
                <td>
                    <div class="shipment-address">
                        <p><strong>Shipping Info:</strong></p>
                        <div class="mt-3">
                            <p>Courier : {{$order?->courier?->courier_name}}</p>
                            <p>Payment method:
                                @if($order->transaction)
                                    @foreach($order->transaction as $transaction)
                                        {{$transaction?->payment_method?->name}}
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                </td>
            </tr> --}}
            </tbody>
        </table>
    </div>

    <div class="row mt-2">
                    {{-- Selected area --}}
        <div class="col-lg-3 mb-3">
            <div class="card card-customize-style" >
                <table class="table px-5">
                    <thead>
                        <tr>
                            <th class="title-style"><span class="title-span">Selected Area</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="data-style">1x Reception Room</td>
                            {{-- <td >Title</td> --}}
                        </tr>        
                        <tr>
                             <td class="data-style">5x Small Meeting Room</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
        {{-- Basic --}}
        <div class="col-lg-3 mb-3">
            <div class="card card-customize-style" >
                <table class="table px-5">
                    <tbody>
                        <tr>
                            <td class="title-style"><span class="title-span">Basic</span></td>
                            <td class="title-style"><span class="title-span"></span></td>
                            <td class="title-style"><span class="title-span">1,759,800.00</span></td>
                        </tr>
                        <tr>
                            <td class="data-style">180</td>
                            <td class="data-style">SFT</td>
                            <td class="data-style">60,000.00</td>
                        </tr>        
                        <tr>
                            <td class="data-style">1000</td>
                            <td class="data-style">SFT</td>
                            <td class="data-style">375,000.00</td>
                        </tr> 
                    </tbody>
                </table>
                
            </div>
        </div>
        {{-- Premium --}}
        <div class="col-lg-3 mb-3">
            <div class="card card-customize-style" >
                <table class="table px-5">
                    <tbody>
                        <tr>
                            <td class="title-style"><span class="title-span">Premium</span></td>
                            <td class="title-style"><span class="title-span"></span></td>
                            <td class="title-style"><span class="title-span">1,759,800.00</span></td>
                        </tr>
                        <tr>
                            <td class="data-style">180</td>
                            <td class="data-style">SFT</td>
                            <td class="data-style">60,000.00</td>
                        </tr>        
                        <tr>
                            <td class="data-style">1000</td>
                            <td class="data-style">SFT</td>
                            <td class="data-style">375,000.00</td>
                        </tr> 
                    </tbody>
                </table>
                
            </div>
        </div>
        {{-- Luxury --}}
        <div class="col-lg-3 mb-3">
            <div class="card card-customize-style" >
                <table class="table px-5">
                    <tbody>
                        <tr>
                            <td class="title-style"><span class="title-span">Luxury</span></td>
                            <td class="title-style"><span class="title-span"></span></td>
                            <td class="title-style"><span class="title-span">1,759,846.00</span></td>
                        </tr>
                        <tr>
                            <td class="data-style">180</td>
                            <td class="data-style">SFT</td>
                            <td class="data-style">180,000.00</td>
                        </tr>        
                        <tr>
                            <td class="data-style">1000</td>
                            <td class="data-style">SFT</td>
                            <td class="data-style">800,000.00</td>
                        </tr> 
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    {{-- <div class="row mt-3">
        <div class="col-12">
            <table class="table table-sm table-bordered table-striped mb-0" style="font-size: 12px">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderitem as $order_item)
                        <tr style="border-bottom: 1px solid #dedede">
                            <td>{{$order_item->name}}</td>
                            <td>{{$order_item->sku}}</td>
                            <td>{{$order_item->unit_price}}Tk.</td>
                            <td>{{$order_item->quantity}}</td>
                            <td style="text-align: right">{{$order_item->total_amount}}Tk.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td style="width: 80%">
                            <p class="mb-0"><small>Order Received By : {{$order?->assiged_to?->name}}</small></p>
                            <p><small>NB: This invoice will be used as a Warranty Card from purchase
                                    date {{$order?->created_at->format('d/m/Y h:i:s A')}} </small></p>
                        </td>
                        <td style="width: 20%">
                            <table class="table table-sm table-bordered table-striped" style="font-size: 12px; width: 250px">
                                <tr>
                                    <th colspan="4" style="text-align: right;">Sub Total:</th>
                                    <td style="text-align: right">{{$order->total_amount}}Tk.</td>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right;">Delivery:</th>
                                    <td style="text-align: right">{{$order->shipping_charge}}Tk.</td>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right;">Discount:</th>
                                    <td style="text-align: right">{{$order->total_discount_amount}}Tk.</td>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right;">Advance:</th>
                                    <td style="text-align: right">{{$order->transaction->sum('amount')}}Tk.</td>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right;">Payable:</th>
                                    <td style="text-align: right">{{$order->total_payable_amount - $order->transaction->sum('amount')}}Tk.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}
</div>

{{-- @if($key % 2 == 0)
    <div style="border-bottom: 2px dotted red; margin: .5in auto; width: 50%;"></div>
@endif --}}


{{-- <script type="text/javascript">
    setTimeout(() => {
        try {
            this.print();
            // this.close()
        } catch (e) {
            window.onload = window.print;
        }
    }, 1000)

</script> --}}
</body>
</html>