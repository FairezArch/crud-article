@include('auth.layouts.header')
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="{{ asset('auth/images/4957136_4957136.jpeg') }}" alt="IMG">
            </div>

            <form action="{{ route('tologin') }}" method="post" class="login100-form validate-form">
                @csrf
                <span class="login100-form-title">
                    Login
                </span>

                @if (Session::has('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Something it's wrong:
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <p>{{ session('message') }}</p>
                    </div>
                @endif

                @if (Session::has('message_suceess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <p>{{ session('message_suceess') }}</p>
                    </div>
                @endif



                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="email" placeholder="Email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-12">
                    <a href="{{ route('forget.password') }}" style="cursor: pointer" target="_blank" class="txt1">
                        Lupa Password
                    </a>
                    <a class="txt2" href="#">
                        &nbsp;
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="#">
                        &nbsp;
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@include('auth.layouts.footer')
