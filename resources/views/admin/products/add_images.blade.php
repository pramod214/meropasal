@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Products Images</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Products Images</li>
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
                        <h4 class="card-title">Add a New Product Images</h4>
                        @if(Session::has('flash_message_error'))
                            <div class="alert alert-error alert-block">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>{!! session('flash_message_error') !!}</strong>
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Product Name</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">
                                        {{$productDetails->product_name}}
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Product Code</label>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">
                                        {{$productDetails->product_code}}
                                    </label>
                                </div>
                            </div>



                            <form method="post" action="{{route('alt.image',$productDetails->id)}}" name="add_attribute" id="add_attribute" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                                <div class="control-group">
                                   <label class="control-label">Image</label>
                                    <div class="controls">
                                        <input type="file" name="image[]" multiple="multiple">
                                    </div>
                                    </div><br>
                                <input type="submit" name="submit" value="Store" class="btn btn-primary">
                            </form>


                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Products Image</h4>
                                        <div class="table-responsive">
                                            <table id="zero_config" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($productImages as $image)
                                                    <tr>
                                                        <td>{{$loop ->index +1}}</td>
                                                        <td>
                                                            <img src="{{asset('public/adminpanel/uploads/products/small/'.$image->image)}}" width="100px">
                                                        </td>

                                                        <td>
                                                            <a rel="{{$image->id}}" rel1="delete-alt-image" href="javascript:" class="btn btn-danger deleteRecord">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>



@endsection

@section('style')
    <link href="{{asset('public/adminpanel/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/adminpanel/sweetalert/sweetalert.css')}}">
@endsection

@section('script')
    <script type="text/javascript" src="{{asset('public/adminpanel/sweetalert/sweetalert.min.js')}}">
    </script>
    <script>
        $(document).ready(function () {
            $(".deleteRecord").click(function(){
                var id = $(this).attr('rel');
                var deleteFunction = $(this).attr('rel1');
                swal({
                        title: "Are You Sure",
                        text: "You will not be able to recover this record again",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, Delete it!"
                    },
                    function(){
                        window.location.href="/meropasal/admin/"+deleteFunction+"/"+id;
                    }
                );
            });
        });
    </script>


    <script>
        @if(Session::has('success'))
        toastr.success('{{Session::get('success')}}')
        @endif
        @if(Session::has('info'))
        toastr.info('{{Session::get('info')}}')
        @endif
        @if(Session::has('danger'))
        toastr.error('{{Session::get('danger')}}')
        @endif
    </script>
@endsection






