<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller{
    //hàm dưới dử dượng Phương thức GET
    //user/add
    public function ShowFormAd(){
        $listGroup = DB ::table('tb_role')
            ->orderBy('name', 'asc')
            ->get();
        $data = ['listGroup' =>$listGroup];

        return View('user.show-form-add', $data);
    }

    //hàm dưới sử dụng phương thức POST, cần truyền vào tham số requet để nhận giá trị post
    //user/save-new-user
    public function SaveNew(Request $request){
        //kiểm tra dữ liệu
        //có 2 cách để kiểm tra
        //1 dùng trực tiếp trong controller


        //2. dùng lớp Requet riêng để kiểm tra hợp lệ dữ liệu
        //thiết lập hàm kiểm tra hợp lệ
        //https://laravel.com/docs/5.8/validation#available-validation-rules
        $checkRules = [
            'username'=>'required|regex:/^[a-zA-Z0-9]{5,30}$/|unique:users,name',
            'password'=>'required|min:6|confirmed',
            'password_confirmation' => 'required|required_with:password|same:password|min:6',
            'email'=>'required|email|unique:users,email',
        ];

        $messages = [
            'username.required'=>'Tên Đăng Nhập Không Đc Để Trống !',
            'password.required'=>'Mật Khẩu Không Đc Để Trống !',
            'password_confirmation.required'=>'Nhập lại mật Khẩu Không được bỏ Trống !',
            'password.confirmed'=>'Xác Nhận Mật Khẩu không Khớp',
            'email.required'=>'Email Không Đc Để Trống !',

            'email.email'=>'email phải đúng định dạng',
            'password.regex'=>'Nhập lại mật khẩu không chính xác',
            'username.regex'=>'Tên Đăng Nhập ít 5 kí tự  và không đặc biệt !',
            'username.unique'=>'Tên Đăng Nhập đã tồn tại',
            'email.unique'=>'Email này đã được đăng ký !'

        ];

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_add_user'))
                ->withErrors($resValidate)
                ->withInput();
        }
        //đến đoạn này là thành công

        //hàm dưới này là để mã hóa password

        $password = Hash::make($request->get('password'));
        $dataInsert = [];
        $dataInsert['username'] = $request->get('username');
        $dataInsert['password'] = $password;
        $dataInsert['email'] = $request->get('email');
        $dataInsert['role_id'] = 2;//là id cuat thành viên

        $resInsert = DB::table('users')->insertGetId($dataInsert);
        return redirect(route('route_add_user'))
            ->with(['msg'=>'Thêm mới thành công: id = '.$resInsert]);
    }
}
