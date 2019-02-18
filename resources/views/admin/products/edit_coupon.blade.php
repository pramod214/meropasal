@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Coupons</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('admin.dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Coupons</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Coupons</h4>
                        @if(Session::has('flash_message_error'))
                            <div class="alert alert-error alert-block">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>{!! session('flash_message_error') !!}</strong>
                            </div>
                        @endif
                        <form class="form" method="post" action="{{route('edit.coupon', $coupon->id)}}" id="add_coupon" name="add_product" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="" class="col-2 col-form-label">Amount Type</label>
                                <div class="col-10">
                                    <select class="custom-select col-12" name="amount_type" id="amount_type">
                                        <option selected disabled>Select</option>
                                        <option value="Percentage" @if($coupon->amount_type == "Percentage")  selected @endif>Percentage</option>
                                        <option value="Fixed" @if($coupon->amount_type == "Fixed")  selected @endif>Fixed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Coupon Code</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="coupon_code" id="coupon_code" value="{{$coupon->coupon_code}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Amount</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="amount" id="amount" value="{{$coupon->amount}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Expiry Date</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="expiry_date" id="expiry_date" value="{{$coupon->expiry_date}}">
                                </div>
                            </div>




                            <div class="form-group m-t-40 row">
                                <label for="status" class="col-2 col-form-label">Status</label>
                                <div class="col-10">
                                    <input type="checkbox" name="status" id="status" value="1" @if($coupon->status == 1) checked @endif>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="text-center">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Update Coupons">
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js?fbclid=IwAR0gve14W2V8EXN6DR0mdbmJ6_pcNkxyRRcUjMPer_eKY7pwwSj8E-WcaKM">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#add_coupon").validate({
                rules: {
                    amount_type: {
                        required: true
                    },
                    coupon_code: {
                        required: true
                    },

                    amount:{
                        required: true
                    },
                    expiry_date:{
                        required: true
                    },

                } ,
                messages : {
                    amount_type: {
                        required: "<span class='text-danger'> Please Enter Amount Type </span>"
                    },
                    coupon_code: {
                        required : "<span class='text-danger'> Please Insert Coupon Code </span>"
                    },
                    amount:{
                        required: "<span class='text-danger'> Please Insert Amount </span>"
                    },
                    expiry_date : {
                        required: "<span class='text-danger'> Please Select Expiry Date </span>"
                    },
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#expiry_date" ).datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                changeMonth:true,
                changeYear:true
            });
        });
    </script>
@endsection