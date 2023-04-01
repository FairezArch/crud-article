@include('auth.layouts.header')
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="card">
            <div class="card-header">Reset Password</div>
            <div class="card-body">
                <form action="{{ route('reset.password.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input type="password" id="password" class="form-control" name="password" required
                                autofocus>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi
                            Password</label>
                        <div class="col-md-6">
                            <input type="password" id="password-confirm" class="form-control"
                                name="password_confirmation" required autofocus>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 text-right offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('auth.layouts.footer')
