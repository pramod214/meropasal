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
                        <h4 class="card-title">Edit a Slider</h4>
                        @if(Session::has('flash_message_info'))
                            <div class="alert alert-info alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! session('flash_message_info') !!}</strong>
                            </div>
                        @endif
                        <form class="form" method="post" action="{{route('edit.slider',$slider->id)}}" id="add_product" name="edit_slider"enctype="multipart/form-data">
                            @csrf


                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Shop Name</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="shop_Name" id="name" value="{{$slider->shop_Name}}" >
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="title" class="col-2 col-form-label">Title</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="title" id="title" value="{{$slider->title}}">
                                </div>
                            </div>

                            <div class="form-group m-t-40 row">
                                <label for="body" class="col-2 col-form-label">Description</label>
                                <div class="col-10">
                                    <textarea class="form-control" type="text" name="body" id="body" rows="10">
                                        {!! htmlspecialchars_decode($slider->body) !!}
                                    </textarea>
                                </div>
                            </div>


                            <div class="form-group m-t-40 row">
                                <label for="name" class="col-2 col-form-label">Image</label>
                                <div class="col-10">
                                    <input class="form-control" type="file" name="image" id="image">
                                    <img src="{{asset('public/adminpanel/uploads/slider'.$slider->image)}}" alt="" width="100px">
                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="text-center">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Update Slider">
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
            $("#edit_slider").validate({
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