<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['Logout','ShowLogin','DoLogin']);
    }

    public function ShowLogin(){

        if(Auth::user() != null ){
            // đã đăng nhập rồi
            return redirect()->route('home_trang_chu');
        }

        return view('auth.login.login-form');
    }
    public function DoLogin(Request $request){
        //hàm xử lý
        $checkRules = [
            'username'=>'required',
            'password'=>'required',
        ];

        $messages = [
            'username.required'=>'Tên Đăng Nhập Không Được Để Trống !',
            'password.required'=>'Mật Khẩu Không Được Để Trống !',

        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        if ($resValidate->fails()) {
            return redirect(route('login'))
                ->withErrors($resValidate)
                ->withInput();
        }

        $data_login = [
            'username'=>$request->get('username'),
            'password'=>$request->get('password')
        ];

        $resLogin = Auth::attempt($data_login);
//        echo '<pre>';
//        print_r($resLogin);
//        echo '</pre>';

        if ($resLogin) {
            echo "OK dang nhap thanh cong, thong tin user: ";
//            echo '<pre>';
//            print_r(Auth::user());
//            echo '</pre>';
            return redirect()->route('home_trang_chu');
            // Authentication passed...
//            return redirect()->intended('dashboard');
        }else{
            die("Tài khoản hoặc mật khẩu không chính xác");

        }
    }
    public function Logout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
