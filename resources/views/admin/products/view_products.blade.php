@extends('admin.adminLayouts.admin_design')

@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">View All Products</h4>
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
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Products Details</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Products Name</th>
                                    <th>Category Level</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$loop->index +1}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->category_name}}</td>
                                        <td>
                                            <img src="{{asset('public/adminpanel/uploads/products/small/'.$product->image)}}" width="100px" alt="">
                                        </td>
                                        <td>{{$product->price}}</td>
                                        <td>
                                            <a href="{{route('product.edit',$product->id)}}" class="btn btn-primary">
                                                <i class="fa fa-edit" ></i>
                                            </a>
                                            <a rel="{{$product->id}}" rel1="delete-product" href="javascript:" class="btn btn-danger deleteRecord">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a data-toggle="modal" data-target="#myModal{{$product->id}}" class="btn btn-warning">
                                                <i class="fa fa-eye" ></i>
                                            </a>
                                            <a href="{{route('product.addAttribute',$product->id)}}" class="btn btn-info">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <a href="{{route('alt.image',$product->id)}}" class="btn btn-success">
                                                <i class="fa fa-images"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div id="myModal{{$product->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">{{$product->product_name}}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Product Code : </strong> {{$product->product_code}}</p>
                                                    <p><strong>Product Color : </strong> {{$product->product_color}}</p>
                                                    <p><strong>Product Price : </strong> {{$product->price}}</p>
                                                    <p><strong>Description</strong>
                                                    {{$product->description}}
                                                    </p>
                                                    <p>
                                                        <strong>Care:</strong>
                                                        {{$product->care}}
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    @endforeach

                                </tbody>

                            </table>
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
    <script src="{{asset('public/adminpanel/assets/extra-libs/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('public/adminpanel/dist/js/pages/datatable/datatable-basic.init.js')}}"></script>

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
