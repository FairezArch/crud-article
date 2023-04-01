@include('auth.layouts.header')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="card">
            <div class="card-header">Reset Password</div>
            <div class="card-body">
                @if (Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form action="{{ route('forget.password.store') }}" class="col-md-12" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>
                        <div class="col-md-10">
                            <input type="text" id="email" class="form-control" name="email" required autofocus>

                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 text-right offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Kirim Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('auth.layouts.footer')
