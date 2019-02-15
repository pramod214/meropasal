@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Slider</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Slider</li>
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
                        <h4 class="card-title">Add a New Slider</h4>
                        @if(Session::has('flash_message_success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_success') !!}</strong>
                            </div>
                        @endif
                        <form class="form" method="post" action="" id="add_product" name="add_slider"enctype="multipart/form-data">
                            @csrf


                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Shop Name</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="shop_Name" id="name" placeholder="Please Enter Shop Name">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="title" class="col-2 col-form-label">Title</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="title" id="title" placeholder="Please Enter Title">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="body" class="col-2 col-form-label">Description</label>
                                <div class="col-10">
                                    <textarea class="form-control" type="text" name="body" id="body" rows="10"></textarea>
                                </div>
                            </div>


                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Image</label>
                                <div class="col-10">
                                    <input class="form-control" type="file" name="image" id="image">
                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="text-center">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Insert Slider">
                                </div>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('script')
    <script src="{{asset('public/js/jquery.validate.js')}}">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#add_slider").validate({
                rules: {
                    shop_Name: {
                        required: true
                    },
                    title: {
                        required: true
                    },
                    body: {
                        required: true
                    },
                    image: {
                        required: true
                    }

                } ,
                messages : {
                    shop_Name: {
                        required: "<span class='text-danger'> Please Enter Shop Name </span>"
                    },
                    title: {
                        required : "<span class='text-danger'> Please Insert Title </span>"
                    },
                    body : {
                        required: "<span class='text-danger'> Please Enter Description </span>"
                    },
                    image : {
                        required: "<span class='text-danger'> Please Select Image </span>"
                    }

                }
            });
        });

    </script>
@endsection