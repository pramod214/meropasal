@extends('frontend.includes.frontend_design')

@section('content')
    <section id="form" style="margin-top:0px"><!--form-->
        <div class="container">
            <div class="row">
                @if(Session::has('flash_message_error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
                @endif
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--user form-->
                        <h2>Login to your account</h2>
                        <form action="#">
                            <input type="text" placeholder="Name" />
                            <input type="email" placeholder="Email Address" />
                            <span>
								<input type="checkbox" class="checkbox">
								Keep me signed in
							</span>
                            <button type="submit" class="btn btn-default">Login</button>
                        </form>
                    </div><!--/user form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>New User Signup!</h2>
                        <form action="{{route('login.register')}}" method="post" id="registerForm" name="registerForm">
                            {{csrf_field()}}
                            <input type="text" placeholder="Name" name="name" id="name"/>
                            <input type="email" placeholder="Email Address" name="email" id="email"/>
                            <input type="password" placeholder="Password" name="password" id="password"/>
                            <button type="submit" class="btn btn-default">Signup</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
    @endsection

@section('script')
    <script src="{{asset('public/js/jquery.validate.js')}}"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#registerForm").validate({
                    rules: {
                        name: {
                            required: true
                        },
                        email:{
                            required: true,
                            email: true
                        },
                        password:{
                            required: true,
                            minLength: 6
                        }
                    } ,
                    messages : {
                        name: {
                            required: "<span class='text-danger'> Please Enter Name </span>"
                        },
                        email: {
                            required: "<span class='text-danger'> Please Enter Email </span>",
                            email: "<span class='text-danger'> Please Enter Valid Email </span>"
                        },
                        password:{
                            required: "<span class='text-danger'> Please Enter Password </span>",
                            minLength: "<span class='text-danger'> Password must be more than 6 characters </span>"
                        }
                    }
                });
            });
    </script>

    <script src="{{asset('public/frontpanel/js/jquery.passtrength.js')}}"></script>
                <script>
                $("#password").passtrength({
                    minChars: 4,
                    passwordToggle: true,
                    tooltip: true,
                    eyeImg: "http://localhost:8000/meropasal/public/frontpanel/images/eye.svg"
                });
    </script>

@endsection