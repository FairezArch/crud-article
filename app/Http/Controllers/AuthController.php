<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('article.index');
        }
        return view('auth.login');
    }

    public function login(AuthRequest $request)
    {
        $data = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        Auth::attempt($data);


        if (Auth::check()) {
            return redirect()->route('article.index');
        } else {
            return redirect()->route('login')->with('message', __('auth.failed'));
        }
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()->route('article.index');
        } else {
            return redirect()->route('register')->with('message', 'something error');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showForm()
    {
       return view('auth.forgetPassword');
    }

    public function storeForm(ForgetPasswordRequest $request)
    {

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function ShowFormReset($token) {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function storeFormReset(ResetPasswordRequest $request)
    {
        $updatePassword = DB::table('password_reset_tokens')->where(['token' => $request->token])->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid data!');
        }

        User::where('email', $updatePassword->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email'=> $updatePassword->email])->delete();
        return redirect('/')->with('message_suceess', 'Password berhasil diubah, silahkan login!');
    }
}
