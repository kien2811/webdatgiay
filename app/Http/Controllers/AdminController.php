<?php
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
session_start();

class AdminController extends Controller{
    public function Index(){
        $data['list_member'] = DB::table('users')->get();
        $data['toltal_member'] = DB::table('users')->paginate(4);
        $data['toltal_order'] = DB::table('tb_order')
            ->join('tb_customer','tb_order.id_customer','=','tb_customer.id')
            ->join('tb_status','tb_order.id_status','=','tb_status.id')
            ->select('tb_order.*','tb_customer.fullname','tb_customer.phone','tb_customer.address','tb_status.status')
            ->orderBy('time','desc')
            ->paginate(5);
        return view('admin.index',$data);
    }
    public function listUser(){
        $data['list_member'] = DB::table('users')
            ->paginate(10);
        $data['role_id'] = DB::table('tb_role')->get();
        return view('admin.user.list-user',$data);
    }
    public function UpdateRoleUser(){
        if (!empty($_GET)){
            $idUser = $_GET['id'];
            $data['list'] = DB::table('users')
                ->where('id','=',$idUser)
                ->get();
            $data['role_id'] = DB::table('tb_role')->get();
        }
        else{
            return redirect(route('route_list_user'));
        }
            return view('admin.user.UpdateRoleUser',$data);
    }
    public function UpdatePmsUser( Request $request){
        $checkRules = [
            'id_role'=>'required|numeric'
        ];

        $messages = [
            'id_role.required'=>'Bạn chưa chọn Quyền',
            'id_role.numeric'=>'Bạn chưa chọn Chọn Thành phần',
        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        $id = $request->get('id');
        if ($resValidate->fails()) {
            return redirect(route('route_UpdateRoleUser').'?id='.$id)
                ->withErrors($resValidate)
                ->withInput();
        }
        //đến đoạn này là thành công
        //hàm dưới này là để mã hóa password

        $dataInsert = [];
        $dataInsert['role_id'] = $request->get('id_role');//là id cuat thành viên

        $resInsert = DB::table('users')
            ->where('id','=',$id)
            ->Update($dataInsert);
        return redirect(route('route_UpdateRoleUser').'?id='.$id)
            ->with(['succes'=>'cập nhật thành công ']);
    }
    public function ShowAddUser(){
        $data['role_id'] = DB::table('tb_role')->get();
        return view('admin.user.show-add-user',$data);
    }
    public function AddUser(Request $request){
        //kiểm tra dữ liệu
        //có 2 cách để kiểm tra
        //1 dùng trực tiếp trong controller
        //2. dùng lớp Requet riêng để kiểm tra hợp lệ dữ liệu
        //thiết lập hàm kiểm tra hợp lệ
        //https://laravel.com/docs/5.8/validation#available-validation-rules
        $checkRules = [
            'name'=>'required|regex:/^[a-zA-Z0-9]{5,30}$/|unique:users,name',
            'password'=>'required|min:8|confirmed',
            'password_confirmation' => 'required|required_with:password|same:password|min:8',
            'email'=>'required|regex:/^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$/|email|unique:users,email',
            'id_role'=>'required|numeric'
        ];

        $messages = [
            'name.required'=>'Tên Đăng Nhập Không Đc Để Trống !',
            'password.required'=>'Mật Khẩu Không Đc Để Trống !',
            'password_confirmation.required'=>'Nhập lại mật Khẩu Không được bỏ Trống !',
            'password.confirmed'=>'Xác Nhận Mật Khẩu không Khớp',
            'email.required'=>'Email Không Đc Để Trống !',
            'id_role.required'=>'Bạn chưa chọn Quyền',

            'email.regex'=>'Email phải đúng kiểu',
            'id_role.numeric'=>'Bạn chưa chọn Chọn Thành phần',
            'email.email'=>'email phải đúng định dạng',
            'password.regex'=>'Nhập lại mật khẩu không chính xác',
            'name.regex'=>'Tên Đăng Nhập ít 5 kí tự  và không đặc biệt !',
            'name.unique'=>'Tên Đăng Nhập đã tồn tại',
            'email.unique'=>'Email này đã được đăng ký !'
        ];

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_show_add_user'))
                ->withErrors($resValidate)
                ->withInput();
        }
        //đến đoạn này là thành công

        //hàm dưới này là để mã hóa password

        $password = Hash::make($request->get('password'));
        $dataInsert = [];
        $dataInsert['name'] = $request->get('name');
        $dataInsert['password'] = $password;
        $dataInsert['email'] = $request->get('email');
        $dataInsert['role_id'] = $request->get('id_role');//là id cuat thành viên

        $resInsert = DB::table('users')->insertGetId($dataInsert);
        return redirect(route('route_show_add_user'))
            ->with(['msg'=>'Thêm mới thành công: id = '.$resInsert]);
    }

    public function DeleteUser(){
        if (!empty($_GET['id'])){
            $id_user = $_GET['id'];
            DB::table('users')
                ->where('id', '=', $id_user)
                ->delete();
            return redirect(route('route_list_user'))
                ->with(['succes'=>'Xóa Dữ Liệu Thành Công']);
        }
        else{
            return redirect(route('route_list_user'));
        }

    }
    public function DuyetKyGui(){
        $data['list_ky_gui'] =  DB::table('tb_ky_gui')
            ->join('tb_mota_kygui', 'tb_ky_gui.id_mota_kygui', '=', 'tb_mota_kygui.id')
            ->join('tb_customer_kygui', 'tb_ky_gui.id_customer_kygui', '=', 'tb_customer_kygui.id')
            ->join('tb_loai_hang','tb_ky_gui.id_loai_hang','=','tb_loai_hang.id')
            ->join('tb_status','tb_ky_gui.id_trang_thai','=','tb_status.id')
            ->join('tb_size_ky_gui','tb_ky_gui.id','=','tb_size_ky_gui.id_giay')
            ->select('tb_ky_gui.*','tb_mota_kygui.time_da_sd',
                'tb_customer_kygui.fullname','tb_customer_kygui.phone',
                'tb_loai_hang.loai_hang','tb_status.status','tb_size_ky_gui.*')
            ->orderBy('time','DESC')
            ->paginate(5);
        $data['view'] ="all";
        $data['total_kg'] = DB::table('tb_ky_gui')->get();

        return view('admin.duyet-ky-gui.list-ky-gui',$data);
    }
    public function DuyetKyGuiChuaXl(){
        $data['list_ky_gui'] =  DB::table('tb_ky_gui')
            ->join('tb_mota_kygui', 'tb_ky_gui.id_mota_kygui', '=', 'tb_mota_kygui.id')
            ->join('tb_customer_kygui', 'tb_ky_gui.id_customer_kygui', '=', 'tb_customer_kygui.id')
            ->join('tb_loai_hang','tb_ky_gui.id_loai_hang','=','tb_loai_hang.id')
            ->join('tb_status','tb_ky_gui.id_trang_thai','=','tb_status.id')
            ->join('tb_size_ky_gui','tb_ky_gui.id','=','tb_size_ky_gui.id_giay')
            ->select('tb_ky_gui.*','tb_mota_kygui.time_da_sd',
                'tb_customer_kygui.fullname','tb_customer_kygui.phone',
                'tb_loai_hang.loai_hang','tb_status.status','tb_size_ky_gui.*')
            ->orderBy('time','DESC')
            ->where('id_trang_thai','=',3)
            ->paginate(5);
        $data['view'] ="Chưa Xử Lý";
        $data['total_kg'] = DB::table('tb_ky_gui')
            ->where('id_trang_thai','=',3)
            ->get();
        return view('admin.duyet-ky-gui.list-ky-gui',$data);
    }
    public function DuyetKyGuiDaNhan(){
        $data['list_ky_gui'] =  DB::table('tb_ky_gui')
            ->join('tb_mota_kygui', 'tb_ky_gui.id_mota_kygui', '=', 'tb_mota_kygui.id')
            ->join('tb_customer_kygui', 'tb_ky_gui.id_customer_kygui', '=', 'tb_customer_kygui.id')
            ->join('tb_loai_hang','tb_ky_gui.id_loai_hang','=','tb_loai_hang.id')
            ->join('tb_status','tb_ky_gui.id_trang_thai','=','tb_status.id')
            ->join('tb_size_ky_gui','tb_ky_gui.id','=','tb_size_ky_gui.id_giay')
            ->select('tb_ky_gui.*','tb_mota_kygui.time_da_sd',
                'tb_customer_kygui.fullname','tb_customer_kygui.phone',
                'tb_loai_hang.loai_hang','tb_status.status','tb_size_ky_gui.*')
            ->orderBy('time','DESC')
            ->where('id_trang_thai','=',1)
            ->paginate(5);
        $data['view'] ="Nhận Hàng";
        $data['total_kg'] = DB::table('tb_ky_gui')
            ->where('id_trang_thai','=',1)
            ->get();
        return view('admin.duyet-ky-gui.list-ky-gui',$data);
    }
    public function DeleteKyGui(){

        if (!empty($_GET['id'])){

            $string = $_GET['id'];

            $url = explode("/",$string);

            $id_kygui = $url[0];
            $size = $url[1];


            DB::table('tb_size_ky_gui')
                ->where([
                    ['id_giay', '=', $id_kygui],
                    ['size', '=', $size],
                ])->delete();

            $data['list_size_dt'] = DB::table('tb_size_ky_gui')
                ->where('id_giay','=',$id_kygui)
                ->paginate(1);


            if(head($data['list_size_dt']) ==0){
                DB::table('tb_ky_gui')
                    ->where('id', '=', $id_kygui)
                    ->delete();
                DB::table('tb_customer_kygui')
                    ->where('id', '=', $id_kygui)
                    ->delete();
                DB::table('tb_mota_kygui')
                    ->where('id', '=', $id_kygui)
                    ->delete();
                return redirect(route('route_list_ky_gui'))->with(['succes'=>'Xóa Thành công']);
            }

            return redirect(route('route_list_ky_gui'))->with(['succes'=>'Xóa Thành công']);
        }
        else{
            return redirect(route('route_list_ky_gui'))->with(['loi_tt'=>'Lỗi Thao Tác !']);
        }
    }
    public function UpDaTe(){

        if (!empty($_GET['id'])){
            $string = $_GET['id'];

            $url = explode("/",$string);

            $id_sp = $url[0];
            $size = $url[1];

            $data['chi_tiet_sp'] = DB::table('tb_ky_gui')
                ->join('tb_mota_kygui', 'tb_ky_gui.id_mota_kygui', '=', 'tb_mota_kygui.id')
                ->join('tb_loai_hang', 'tb_ky_gui.id_loai_hang', '=', 'tb_loai_hang.id')
                ->join('tb_size_ky_gui','tb_ky_gui.id_size','=','tb_size_ky_gui.id_giay')
                ->select('tb_ky_gui.*','tb_mota_kygui.*','tb_loai_hang.loai_hang','tb_size_ky_gui.*')
                ->where([
                    ['id_giay', '=', $id_sp],
                    ['size', '=', $size],
                ])
                ->get();

            $data['list_loai_hang']=  DB::table('tb_loai_hang')->get();
            $data['trang_thai']=  DB::table('tb_status')
                ->where('id','=',1)
                ->orwhere('id','=',2)
                ->get();
            return view('admin.duyet-ky-gui.update-ky-gui',$data);
        }
        else{
            return redirect(route('route_list_ky_gui'))->with(['loi_tt'=>'Lỗi Thao Tác !']);
        }


    }
    public function SaveUpDaTe(Request $request){

        if (!empty($request->get('id_giay'))){
            $id_sp = $request->get('id_giay');
            $size = $request->get('size');
            $checkRules = [
                'name'=>'required',
                'price'=>'required',
                'size'=>'required',
                'quantity'=>'required|regex:/^[0-9]{1,1000}$/',
                'time_da_sd'=>'required',
                'thuonghieu'=>'required',
                'noi_dung_mota'=>'required',
                'id_loai_hang'=>'required|exists:tb_loai_hang,id',
                'id_trang_thai'=>'required|exists:tb_status,id',
            ];
            $messages = [
                'name.required'=>'Trường tên không được trống',
                'price.required'=>'Trường giá không được trống',
                'size.required'=>'Trường size không được trống',
                'quantity.required'=>'Trường số lượng sai số liệu',
                'quantity.regex'=>'dữ liệu không tồn tạii',
                'time_da_sd.required'=>'Phải có thời gian sử dụng',
                'thuonghieu.required'=>'Trường thương hiệu không đc trống',
                'noi_dung_mota.required'=>'Trường nội dung không được trống',
                'id_loai_hang.exists'=>'Bạn phải chọn loại hàng',
                'id_trang_thai.exists'=>'Bạn phải chọn Trạng Thái',
            ];
            $resValidate = Validator::make($request->all(), $checkRules,$messages);

            if ($resValidate->fails()) {
                return redirect(route('route_update_ky_gui').'?id='.$id_sp.'/'.$size)
                    ->withErrors($resValidate)
                    ->withInput();
            }
            if ($request->get('id_trang_thai')==2){//nếu từ chối hàng thì xóa luôn đơn hàng khỏi db
                return redirect(route('route_delete_ky_gui').'?id='.$id_sp.'/'.$size);
            }
            $dataUp =[];
            $dataUp['name'] =$request->get('name');
            $dataUp['price'] = str_replace(',','',$request->get('price'));
            $dataUp['id_loai_hang'] =$request->get('id_loai_hang');
            $dataUp['id_trang_thai'] =$request->get('id_trang_thai');
            $dataUp['thuonghieu'] =$request->get('thuonghieu');
            $dataUp['time_da_sd'] =$request->get('time_da_sd');
            $dataUp['noi_dung_mota'] =$request->get('noi_dung_mota');
            $dataUp['quantity'] = $request->get('quantity');
            $dataUp['size'] = $size;

            DB::table('tb_size_ky_gui')
                ->Where('id_giay','=',$id_sp)
                ->update(
                    ['size' => $dataUp['size'],
                        'quantity' => $dataUp['quantity'],
                    ]);

            DB::table('tb_ky_gui')
                ->Where('id','=',$id_sp)
                ->update(
                    ['name' =>  $dataUp['name'],
                        'price' => $dataUp['price'],
                        'id_loai_hang' => $dataUp['id_loai_hang'],
                        'id_trang_thai' => $dataUp['id_trang_thai'],
                        'thuonghieu' => $dataUp['thuonghieu'],
                    ]);

            DB::table('tb_mota_kygui')
                ->Where('id','=',$id_sp)
                ->update(
                    ['time_da_sd' => $dataUp['time_da_sd'],
                        'noi_dung_mota' => $dataUp['noi_dung_mota'],
                    ]);

            return redirect(route('route_update_ky_gui').'?id='.$id_sp.'/'.$size)
                ->with(['succes_update'=>'Lưu Dữ Liệu Thành Công']);

        }
        else{
            return redirect(route('route_list_ky_gui'));
        }
    }
    public function QuanLyDh(){
        $data['list_dh'] = DB::table('tb_order')
            ->join('tb_customer','tb_order.id_customer','=','tb_customer.id')
            ->join('tb_status','tb_order.id_status','=','tb_status.id')
            ->select('tb_order.*','tb_customer.fullname','tb_customer.phone','tb_customer.address','tb_status.status')
            ->orderBy('time','desc')
            ->paginate(12);
        $data['list_status'] = DB::table('tb_status')
            ->where('id','=',5)
            ->orWhere('id','=',6)
            ->orWhere('id','=',7)
            ->get();
        $data['total_dh']= DB::table('tb_order')->get();
        $data['view']="danh-sach";
        return view('admin.quan-ly-dh.list-dh',$data);
    }
    public function QuanLyDhChuaXl(){
        $data['list_dh'] = DB::table('tb_order')
            ->where('status','=','Đang Xử Lý')
            ->join('tb_customer','tb_order.id_customer','=','tb_customer.id')
            ->join('tb_status','tb_order.id_status','=','tb_status.id')
            ->select('tb_order.*','tb_customer.fullname','tb_customer.phone','tb_customer.address','tb_status.status')
            ->orderBy('time','desc')
            ->paginate(12);
        $data['list_status'] = DB::table('tb_status')
            ->where('id','=',6)
            ->orWhere('id','=',5)
            ->get();
        $data['total_dh']= DB::table('tb_order')
            ->where('id_status','=',3)
            ->get();
        $data['view']="danh-sach-chua-xl";
        return view('admin.quan-ly-dh.list-dh',$data);
    }
    public function QuanLyDhDaXl(){
        $data['list_dh'] = DB::table('tb_order')
            ->where('status','=','Đang Giao Hàng')
            ->orWhere('status','=','Giao Hành Thành Công')
            ->join('tb_customer','tb_order.id_customer','=','tb_customer.id')
            ->join('tb_status','tb_order.id_status','=','tb_status.id')
            ->select('tb_order.*','tb_customer.fullname','tb_customer.phone','tb_customer.address','tb_status.status')
            ->orderBy('time','desc')
            ->paginate(12);
        $data['list_status'] = DB::table('tb_status')
            ->where('id','=',6)
            ->orWhere('id','=',5)
            ->get();
        $data['total_dh']= DB::table('tb_order')
            ->where('id_status','=',5)
            ->orWhere('id_status','=',6)
            ->get();
        $data['view']="danh-sach-da-xl";
        return view('admin.quan-ly-dh.list-dh',$data);
    }
    public function QuanLyUpdateDh(Request $request){
        $id_order = $request->get('id_oder');
        $id_stt = $request->get('id_status');

        DB::table('tb_order')
            ->Where('id','=',$id_order)
            ->update(
                ['id_status' => $id_stt]
            );

        return redirect(route('route_quan_ly_dh_admin'))
            ->with(['succes_update'=>'Trạng thái đã được thay đổi !']);
    }
    public function DetailDh(){
        $id_oder = $_GET['id'];
        $data['detail_oder'] = DB::table('tb_order_detail')
            ->where('id_order','=',$id_oder)
            ->get();

        $data['tt_giay']=[];


        foreach ($data['detail_oder'] as $sp){

            $data['list_tb_kg'] = DB::table('tb_ky_gui')
                ->where('id','=',$sp->id_giay)
                ->paginate(1);

            $data['list_tb_giay'] = DB::table('tb_giay')
                ->where('id','=',$sp->id_giay)
                ->paginate(1);

            if(head($data['list_tb_kg']) >0 || head($data['list_tb_giay']) >0) {
                if ($sp->phan_loai_giay == 'sản phẩm new'){
                    $id_giay = $sp->id_giay;

                    $data['tt_giay'][$id_giay.$sp->phan_loai_giay] =[];

                    $data['giay_new_01'] = DB::table('tb_giay')
                        ->where('id','=',$id_giay)
                        ->first();
                    $data['tt_giay'][$id_giay.$sp->phan_loai_giay] =$data['giay_new_01'];

                }
                if ($sp->phan_loai_giay == 'sản phẩm ký gửi'){
                    $id_giay = $sp->id_giay;

                    $data['tt_giay'][$id_giay.$sp->phan_loai_giay] =[];

                    $data['giay_kgui_01'] = DB::table('tb_ky_gui')
                        ->where('id','=',$id_giay)
                        ->first();
                    $data['tt_giay'][$id_giay.$sp->phan_loai_giay] =$data['giay_kgui_01'];;
                }

            }else{
                return redirect(route('route_quan_ly_dh_admin'))
                    ->with(['loi_ko_sp'=>'Sản Phẩm này không còn tồn tại !']);
            }




        }
        return view('admin.quan-ly-dh.detail-dh',$data);

    }
    public function ListPmsRole(){
        $data['list_role'] = DB::table('tb_role')->get();
        $data['permission'] = DB::table('role_permission')
            ->join('tb_role','role_permission.role_id','=','tb_role.id')
            ->join('tb_permission','tb_permission.id','=','role_permission.permission_id')
            ->paginate(5);

        return view('admin.role_permission.list-role-pms',$data);
    }
    public function Seach_role(Request $request){
       $id_role = $request->get('id_role');
       if ($id_role == 0){
           return redirect(route('route_list_role_pms'))
               ->withErrors([])
               ->withInput();
       }
        $data['list_role'] = DB::table('tb_role')->get();
        $data['permission'] = DB::table('role_permission')
            ->where('role_id','=',$id_role)
            ->join('tb_role','role_permission.role_id','=','tb_role.id')
            ->join('tb_permission','tb_permission.id','=','role_permission.permission_id')
            ->paginate(5);
        $data['seach'] = DB::table('tb_role')
            ->where('id','=',$id_role)
            ->get();

        return view('admin.role_permission.list-role-pms',$data);
    }
    public function AddPmsRole(){
        $data['list_role'] = DB::table('tb_role')->get();
        $data['permission'] = DB::table('tb_permission')->get();
        return view('admin.role_permission.add-role-pms',$data);
    }
    public function AddSavePmsRole(Request $request){
//        print_r($request->all());
//        return;

        $data['list_pms']= DB::table('tb_permission')->get();

        foreach ($data['list_pms'] as $pms){

            if (!empty($request->get('pms_'.$pms->id))){

                $result_pms = DB::table('role_permission')
                    ->where([
                        ['role_id', '=', $request->get('role_id')],
                        ['permission_id', '=', $request->get('pms_'.$pms->id)],
                    ])
                    ->first();

                if (is_null($result_pms)) {
                    $role_id = $request->get('role_id');
                    $pms_id= $request->get('pms_'.$pms->id);
//                    echo $role_id. '---' .$pms_id;
//                    echo '<br>';
                    DB::table('role_permission')->insert(
                        ['role_id' => $role_id,
                            'permission_id' =>  $pms_id,
                        ]);

                }

            }

        }
        return redirect(route('route_add_role_pms'))
            ->with(['succes'=>'Thêm Quyền cho nhóm tài khoản thành công !']);
    }
    public function DeletePmsRole(){
        if (!empty($_GET['id'])){
            $string = $_GET['id'];

            $url = explode("/",$string);

            $id_PSM = $url[0];
            $id_role = $url[1];
//            echo $id_PSM;
//            echo '<br>';
//            echo $id_role;
//            return;

            DB::table('role_permission')
                ->where([
                    ['role_id', '=', $id_role],
                    ['permission_id', '=', $id_PSM],
                ])->delete();


            return redirect(route('route_list_role_pms'))
                ->with(['succes'=>'Xóa Dữ Liệu Thành Công']);
        }
        else{
            return redirect(route('route_list_role_pms'));
        }

    }
    public function ListPermission(){
        $data['list_permission'] = DB::table('tb_permission')
            ->paginate(12);
        return view('admin.permission.list-pms',$data);
    }
    public function FormAddGiay(){
        if (empty(Auth::check())){
            echo '<script>';
            echo 'confirm("bạn không có quyền truy cập")';
            echo '</script>';
            return redirect()->route('route_home');
        }


        $data['list_gender'] = DB::table('tb_gender')->get();
        $data['list_loai_hang'] = DB::table('tb_loai_hang')->get();

        return view('admin.san-pham.add-san-pham',$data);
    }
    public function SaveNewGiay(Request $request){

        if (empty($request->get('sz_35')|| $request->get('sz_36') ||
            $request->get('sz_37') || $request->get('sz_38') ||
            $request->get('sz_39') || $request->get('sz_40') ||
            $request->get('sz_41') || $request->get('sz_42') ||
            $request->get('sz_43') || $request->get('sz_44')
        )){

            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);

        }
        if (!empty($request->get('sz_35')) && $request->get('qtt_35') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_36')) && $request->get('qtt_36') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_37')) && $request->get('qtt_37') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_38')) && $request->get('qtt_38') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_39')) && $request->get('qtt_39') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_40')) && $request->get('qtt_40') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_41')) && $request->get('qtt_41') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_42')) && $request->get('qtt_42') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_43')) && $request->get('qtt_43') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }
        if (!empty($request->get('sz_44')) && $request->get('qtt_44') == 0){
            redirect(route('route_add_giay'))
                ->with(['f_size'=>'Bạn cần phải chọn size & số lượng']);
        }


        $checkRules = [
            //đoạn này xử lý cho phần thông tin sản phầm
            'name_giay'=>'required',
            'price_giay'=>'required|regex:/^[0-9]{1,1000}$/',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
            'id_gender'=>'required|exists:tb_gender,id',
            'thuong_hieu'=>'required',
            'file_anh'=>'required',
            //đoạn này Xử lý cho phần mô tả
            'cap_mo_ta'=>'required',
            'noi_dung_mo_ta'=>'required',
            'mau_sac'=>'required',
            'noi_sx'=>'required',
            'img_mt_01'=>'required',
            'img_mt_02'=>'required',
            'img_mt_03'=>'required',
            'img_mt_04'=>'required',

        ];

        $messages = [
            //phần lỗi thông tin sản phẩm
            'name_giay.required'=>'Tên Giày không được để trống !',
            'price_giay.required'=>'Giá Giày không được để trống và chỉ nhập số !',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng !',
            'id_gender.exists'=>'Bạn phải chọn Giới tính !',
            'thuong_hieu.required'=>'Thương hiệu không được trống !',
            'file_anh.required'=>'Ảnh Giày không được trống !',
            //phần này ghi lỗi của mô tả
            'cap_mo_ta.required'=>'Bạn Cần thêm Cap mô tả !',
            'noi_dung_mo_ta.required'=>'Bạn Cần Nội dung mô tả !',
            'mau_sac.required'=>'Bạn Cần thêm Màu sắc cho sản phẩm !',
            'noi_sx.required'=>'Bạn Cần thêm Nơi Sản Xuất !',
            'img_mt_01.required'=>'Bạn Cần thêm Ảnh mô tả 01 !',
            'img_mt_02.required'=>'Bạn Cần thêm Ảnh mô tả 02 !',
            'img_mt_03.required'=>'Bạn Cần thêm Ảnh mô tả 03 !',
            'img_mt_04.required'=>'Bạn Cần thêm Ảnh mô tả 04 !',

        ];


        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_add_giay'))
                ->withErrors($resValidate)
                ->withInput();
        }


        //đường dẫn file ảnh và tên ảnh sản phẩm
        $data['file_path_img_sp']= $request->file('file_anh')->store('public/hinh-anh-san-pham');
        $data['file_img_sp']= $request->file('file_anh')->getClientOriginalName();

        //đường dẫn file ảnh và tên ảnh mô tả sản phẩm
        $data['file_path_img_01_mota']= $request->file('img_mt_01')->store('public/hinh-anh-mo-ta-san-pham');
        $data['file_img_01_mota']= $request->file('img_mt_01')->getClientOriginalName();

        $data['file_path_img_02_mota']= $request->file('img_mt_02')->store('public/hinh-anh-mo-ta-san-pham');
        $data['file_img_02_mota']= $request->file('img_mt_02')->getClientOriginalName();

        $data['file_path_img_03_mota']= $request->file('img_mt_03')->store('public/hinh-anh-mo-ta-san-pham');
        $data['file_img_03_mota']= $request->file('img_mt_03')->getClientOriginalName();

        $data['file_path_img_04_mota']= $request->file('img_mt_04')->store('public/hinh-anh-mo-ta-san-pham');
        $data['file_img_04_mota']= $request->file('img_mt_04')->getClientOriginalName();

        //sửa link ảnh-sản phẩm
        $data['file_path_img_sp'] = str_replace('public/','',$data['file_path_img_sp']);


        //sửa link ảnh-mô tả
        $data['file_path_img_01_mota'] = str_replace('public/','',$data['file_path_img_01_mota']);
        $data['file_path_img_02_mota'] = str_replace('public/','',$data['file_path_img_02_mota']);
        $data['file_path_img_03_mota'] = str_replace('public/','',$data['file_path_img_03_mota']);
        $data['file_path_img_04_mota'] = str_replace('public/','',$data['file_path_img_04_mota']);


        $dataMtGiay = [];
        $dataMtGiay['image_1'] = $data['file_path_img_01_mota'];
        $dataMtGiay['image_2'] = $data['file_path_img_02_mota'];
        $dataMtGiay['image_3'] = $data['file_path_img_03_mota'];
        $dataMtGiay['image_4'] = $data['file_path_img_04_mota'];
        $dataMtGiay['noi_dung_mota'] = $request->get('noi_dung_mo_ta');
        $dataMtGiay['mausac'] = $request->get('mau_sac');
        $dataMtGiay['cap_mo_ta'] = $request->get('cap_mo_ta');
        $dataMtGiay['noi_SX'] = $request->get('noi_sx');

        $resmtGiay = DB::table('tb_mota')->insertGetId($dataMtGiay);
        if (isset($resmtGiay)){
            $dataGiay = [];
            $dataGiay['name'] = $request->get('name_giay');
            $dataGiay['price'] = $request->get('price_giay');
            $dataGiay['id_mota'] = $resmtGiay;
            $dataGiay['id_sale'] = 1;
            $dataGiay['id_loai_hang'] = $request->get('id_loai_hang');
            $dataGiay['id_gender'] = $request->get('id_gender');
            $dataGiay['image'] = $data['file_path_img_sp'];
            $dataGiay['uid'] = Auth::user()->id;
            $dataGiay['thuonghieu'] = $request->get('thuong_hieu');

            $idGiay = DB::table('tb_giay')->insertGetId($dataGiay);
            if (isset($idGiay)){
                $dataSize = [];
                if (!empty( $request->get('sz_35') && $request->get('qtt_35')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_35');
                    $dataSize['quantity'] = $request->get('qtt_35');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }

                if (!empty( $request->get('sz_36') && $request->get('qtt_36')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_36');
                    $dataSize['quantity'] = $request->get('qtt_36');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_37') && $request->get('qtt_37')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_37');
                    $dataSize['quantity'] = $request->get('qtt_37');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_38') && $request->get('qtt_38')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_38');
                    $dataSize['quantity'] = $request->get('qtt_38');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_39') && $request->get('qtt_39')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_39');
                    $dataSize['quantity'] = $request->get('qtt_39');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_40') && $request->get('qtt_40')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_40');
                    $dataSize['quantity'] = $request->get('qtt_40');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_41') && $request->get('qtt_41')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_41');
                    $dataSize['quantity'] = $request->get('qtt_41');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_42') && $request->get('qtt_42')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_42');
                    $dataSize['quantity'] = $request->get('qtt_42');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_43') && $request->get('qtt_43')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_43');
                    $dataSize['quantity'] = $request->get('qtt_43');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }
                if (!empty( $request->get('sz_44') && $request->get('qtt_44')>0)){
                    $dataSize['id'] = $idGiay;
                    $dataSize['size'] = $request->get('sz_44');
                    $dataSize['quantity'] = $request->get('qtt_44');

                    DB::table('tb_size')->insert(
                        ['id_giay' => $dataSize['id'],
                            'size' =>  $dataSize['size'],
                            'phan_loai_giay' =>  'giày mới',
                            'quantity' => $dataSize['quantity'],
                        ]);
                }

                DB::table('tb_giay')
                    ->where('id','=',$idGiay)
                    ->update(
                        ['id_size' => $idGiay]
                    );
                return redirect(route('route_add_giay'))
                    ->with(['ss_add'=>'Thêm Sản Phẩm Thành Công !']);

            }

        }

//        $dataInsert['name_bk'] = $request->get('name_bk');
//        $dataInsert['image'] =  $data['file_path'];
//
//        return redirect(route('route_add_giay'));
//        echo '<pre>';
//        print_r($request->all());
    }
    public function ListSanPham(){
        $data['loai_hang'] = DB::table('tb_loai_hang')->get();
        $data['toltal_sp'] = DB::table('tb_giay')->get();
        $data['list'] = DB::table('tb_giay')
            ->join('tb_loai_hang','tb_loai_hang.id','=','tb_giay.id_loai_hang')
            ->join('users','users.id','=','tb_giay.uid')
            ->join('tb_gender','tb_gender.id','=','tb_giay.id_gender')
            ->select('tb_giay.*','tb_loai_hang.loai_hang','users.email','tb_gender.gender')
            ->orderBy('id','asc')
            ->paginate(5);
        //            ->join('users','users.id','=','tb_giay.uid')


//        echo '<pre>';
//        print_r($data['list']);
//        echo head($data['list']);
//        return;
        if (head($data['list'])>0){
            foreach ($data['list'] as $val){
                $id_giay = $val->id_size;
                $data['list_size'][$id_giay]=[];
                $data['list_size'][$id_giay] =DB::table('tb_size')
                    ->where('id_giay','=',$id_giay)
                    ->get();
            }

        }


        return view('admin.san-pham.list-san-pham-admin',$data);
    }
    public function UpdateSanpham(){
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $data['list'] = DB::table('tb_giay')
                ->where('tb_giay.id','=',$id)
                ->join('tb_loai_hang', 'tb_loai_hang.id', '=', 'tb_giay.id_loai_hang')
                ->join('tb_mota', 'tb_mota.id', '=', 'tb_giay.id_mota')
                ->join('tb_gender', 'tb_gender.id', '=', 'tb_giay.id_gender')
                ->select('tb_giay.*','tb_loai_hang.loai_hang',
                    'tb_mota.noi_dung_mota','tb_mota.mausac','tb_mota.cap_mo_ta',
                    'tb_mota.image_1','tb_mota.image_2','tb_mota.image_3','tb_mota.image_4',
                    'tb_mota.noi_SX','tb_gender.gender'
                    )
                ->get();
            $data['list_gender'] = DB::table('tb_gender')
                ->get();
            $data['list_loai_hang'] = DB::table('tb_loai_hang')->get();
            return view('admin.san-pham.update-san-pham-admin', $data);
        }else{
            return redirect(route('route_list_san_pham_admin'));
        }
    }
    public function UpSanPham(Request $request){

        $checkRules = [

            //đoạn này xử lý cho phần thông tin sản phầm
            'name_giay'=>'required',
            'price_giay'=>'required|regex:/^[0-9]{1,1000}$/',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
            'id_gender'=>'required|exists:tb_gender,id',
            'thuong_hieu'=>'required',
            //đoạn này Xử lý cho phần mô tả
            'cap_mo_ta'=>'required',
            'noi_dung_mo_ta'=>'required',
            'mau_sac'=>'required',
            'noi_sx'=>'required'
        ];

        $messages = [
            //phần lỗi thông tin sản phẩm
            'name_giay.required'=>'Tên Giày không được để trống',
            'price_giay.required'=>'Giá Giày không được để trống và chỉ nhập số',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng',
            'id_gender.exists'=>'Bạn phải chọn loại Giới Tính',
            'thuong_hieu.required'=>'Thương hiệu không được trống',
            //phần này ghi lỗi của mô tả
            'cap_mo_ta.required'=>'Bạn Cần thêm Cap mô tả',
            'noi_dung_mo_ta.required'=>'Bạn Cần Nội dung mô tả',
            'mau_sac.required'=>'Bạn Cần thêm Màu sắc cho sản phẩm',
            'noi_sx.required'=>'Bạn Cần thêm Nơi Sản Xuất',

        ];

//        echo '<pre>';
//        print_r($request->all());
//        echo '</pre>';
//        return;

        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        $id = $request->get('id');
        $idmota = $request->get('id_mota');
        if ($resValidate->fails()) {
            return redirect(route('route_update_san_pham_admin').'?id='.$id)
                ->withErrors($resValidate)
                ->withInput();
        }
        if (!empty($request->file('image_1'))){
            //thêm link ảnh vào thư mục
            $data['file_path_img_01_mota']= $request->file('image_1')->store('public/hinh-anh-mo-ta-san-pham');
            $data['file_img_01_mota']= $request->file('image_1')->getClientOriginalName();
            //sửa tên file ảnh
            $data['image_1'] = str_replace('public/','',$data['file_path_img_01_mota']);
            DB::table('tb_mota')
                ->where('id','=',$idmota)
                ->update(['image_1'=>$data['image_1']]);
        }
        if (!empty($request->file('image_2'))){
            //thêm link ảnh vào thư mục
            $data['file_path_img_02_mota']= $request->file('image_2')->store('public/hinh-anh-mo-ta-san-pham');
            $data['file_img_02_mota']= $request->file('image_2')->getClientOriginalName();
            //sửa tên file ảnh
            $data['image_2'] = str_replace('public/','',$data['file_path_img_02_mota']);
            DB::table('tb_mota')
                ->where('id','=',$idmota)
                ->update(['image_2'=>$data['image_2']]);
        }
        if (!empty($request->file('image_3'))){
            //thêm link ảnh vào thư mục
            $data['file_path_img_03_mota']= $request->file('image_3')->store('public/hinh-anh-mo-ta-san-pham');
            $data['file_img_03_mota']= $request->file('image_3')->getClientOriginalName();
            //sửa tên file ảnh
            $data['image_3'] = str_replace('public/','',$data['file_path_img_03_mota']);
            DB::table('tb_mota')
                ->where('id','=',$idmota)
                ->update(['image_3'=>$data['image_3']]);
        }
        if (!empty($request->file('image_4'))){
            //thêm link ảnh vào thư mục
            $data['file_path_img_04_mota']= $request->file('image_4')->store('public/hinh-anh-mo-ta-san-pham');
            $data['file_img_04_mota']= $request->file('image_4')->getClientOriginalName();
            //sửa tên file ảnh
            $data['image_4'] = str_replace('public/','',$data['file_path_img_04_mota']);
            DB::table('tb_mota')
                ->where('id','=',$idmota)
                ->update(['image_4'=>$data['image_4']]);
        }

        $dataMtGiay['noi_dung_mota'] = $request->get('noi_dung_mo_ta');
        $dataMtGiay['mausac'] = $request->get('mau_sac');
        $dataMtGiay['cap_mo_ta'] = $request->get('cap_mo_ta');
        $dataMtGiay['noi_SX'] = $request->get('noi_sx');
        $idmota = $request->get('id_mota');
        $resmtGiay = DB::table('tb_mota')
            ->where('id','=',$idmota)
            ->Update($dataMtGiay);
        if (isset($resmtGiay)){

            if (!empty($request->file('image'))){
                //đường dẫn file ảnh và tên ảnh sản phẩm
                $data['file_path_img_sp']= $request->file('image')->store('public/hinh-anh-san-pham');
                $data['file_img_sp']= $request->file('image')->getClientOriginalName();
                //sửa link ảnh-sản phẩm
                $data['file_path_img_sp'] = str_replace('public/','',$data['file_path_img_sp']);
                $dataGiay['image'] = $data['file_path_img_sp'];

                DB::table('tb_giay')
                    ->where('id','=',$id)
                    ->update(['image'=>$dataGiay['image']]);

            }

            $dataGiay = [];
            $idmota = $request->get('id_mota');
            $dataGiay['name'] = $request->get('name_giay');
            $dataGiay['price'] = $request->get('price_giay');
            $dataGiay['id_sale'] = 1;
            $dataGiay['id_loai_hang'] = $request->get('id_loai_hang');
            $dataGiay['id_gender'] = $request->get('id_gender');
            $dataGiay['uid'] = $request->get('uid');
            $dataGiay['thuonghieu'] = $request->get('thuong_hieu');
            $id = $request->get('id_mota');
            $resGiay = DB::table('tb_giay')
                ->where('id','=',$idmota)
                ->Update($dataGiay);
            return redirect(route('route_update_san_pham_admin').'?id='.$id)
                ->with(['msg'=>'Sửa thông tin thành công']);
        }
        return redirect(route('route_update_san_pham_admin'));
    }
    public function FormUpdateSize(){

        if (isset($_GET['id'])){
            $id_giay = $_GET['id'];
            $data['list'] = DB::table('tb_size')
                ->where('id_giay','=',$id_giay)
                ->orderBy('size','asc')
                ->get();
        return view('admin.san-pham.update-size',$data);
        }
        else{
            return redirect(route('route_list_san_pham_admin'));
        }

    }
    public function deleteSize(Request $request){
        $id_giay = $request->get('id_giay');
        if (empty($request->get('size_35') || $request->get('size_36') ||
            $request->get('size_37') || $request->get('size_38')||
            $request->get('size_39') || $request->get('size_40')||
            $request->get('size_41') || $request->get('size_42')||
            $request->get('size_43') || $request->get('size_44')
        )){
           return redirect(route('route_update_size_san_pham_admin').'?id='.$id_giay)
                ->with(['f_size_01'=>"Thao Tác lỗi ! phải có size được chọn."]);
        }
        if (!empty($request->get('size_35'))){
            $size = $request->get('size_35');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_36'))){
            $size = $request->get('size_36');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_37'))){
            $size = $request->get('size_37');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }

        if (!empty($request->get('size_38'))){
            $size = $request->get('size_38');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_39'))){
            $size = $request->get('size_39');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_40'))){
            $size = $request->get('size_40');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_41'))){
            $size = $request->get('size_41');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_42'))){
            $size = $request->get('size_42');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_43'))){
            $size = $request->get('size_43');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        if (!empty($request->get('size_44'))){
            $size = $request->get('size_44');
            DB::table('tb_size')
                ->where([
                    ['id_giay', '=', $id_giay],
                    ['size', '=', $size],
                    ['phan_loai_giay', '=', 'giày mới'],
                ])->delete();
        }
        return redirect(route('route_update_size_san_pham_admin').'?id='.$id_giay)
            ->with(['delete_ss'=>"Xóa Size Giày Thành Công !"]);

    }
    public function AddSize(Request $request){
        $id_giay = $request->get('id_giay');
        if (empty($request->get('size_35') || $request->get('size_36') ||
            $request->get('size_37') || $request->get('size_38')||
            $request->get('size_39') || $request->get('size_40')||
            $request->get('size_41') || $request->get('size_42')||
            $request->get('size_43') || $request->get('size_44')
        )){
            return redirect(route('route_update_size_san_pham_admin').'?id='.$id_giay)
                ->with(['f_size_02'=>"Thao Tác lỗi ! phải có size được chọn."]);
        }
        if (!empty($request->get('size_35'))){
            $size = $request->get('size_35');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_36'))){
            $size = $request->get('size_36');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_37'))){
            $size = $request->get('size_37');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_38'))){
            $size = $request->get('size_38');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_39'))){
            $size = $request->get('size_39');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_40'))){
            $size = $request->get('size_40');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_41'))){
            $size = $request->get('size_41');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_42'))){
            $size = $request->get('size_42');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_43'))){
            $size = $request->get('size_43');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        if (!empty($request->get('size_44'))){
            $size = $request->get('size_44');
            DB::table('tb_size')->insert(
                ['id_giay' => $id_giay,
                    'size' => $size,
                    'phan_loai_giay' => 'giày mới'
                ]
            );
        }
        return redirect(route('route_update_size_san_pham_admin').'?id='.$id_giay)
            ->with(['add_ss'=>"Thêm mới size thành công !"]);

    }
    public function deleteSanPham(){
        if (!empty($_GET['id'])){
            $id_sp = $_GET['id'];
            DB::table('tb_size')
                ->where('id_giay', '=', $id_sp)
                ->delete();
            DB::table('tb_giay')
                ->where('id', '=', $id_sp)
                ->delete();
            DB::table('tb_mota')
                ->where('id', '=', $id_sp)
                ->delete();

            return redirect(route('route_list_san_pham_admin'))
                ->with(['succes'=>'Xóa Dữ Liệu Thành Công']);
        }
        else{
            return redirect(route('route_list_san_pham_admin'));
        }
    }
    public  function ListSale(){
        $data['list_sale'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->join('tb_loai_hang','tb_giay.id_loai_hang','=','tb_loai_hang.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram','tb_loai_hang.loai_hang')
            ->paginate(5);
        $data['total_sp']=DB::table('tb_giay')
            ->get();
        $data['op_sale'] = DB::table('tb_sale')
            ->get();
        $data['view'] = 'all';

        //lấy id giày để lấy size
        if (head($data['list_sale'])>0){
            foreach ($data['list_sale'] as $val){
                $id_giay =$val->id_size;
                $data['list_size'][$id_giay] =[];
                $data['list_size'][$id_giay] =DB::table('tb_size')
                    ->where('id_giay','=',$id_giay)
                    ->get();
//                echo '<pre>';
//                print_r($data['list_size']);
//                echo '</pre>';
            }
        }

        return view('admin.quan-li-sale.list-sale',$data);
    }
    public  function ListGiaySale(){
        $data['list_sale'] = DB::table('tb_giay')
            ->where('id_sale','>',1)
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->join('tb_loai_hang','tb_giay.id_loai_hang','=','tb_loai_hang.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram','tb_loai_hang.loai_hang')
            ->paginate(5);
        $data['total_sp']=DB::table('tb_giay')
            ->where('id_sale','>',1)
            ->get();
        $data['op_sale'] = DB::table('tb_sale')
            ->get();
        $data['view'] = 'sale';

        //lấy id giày để lấy size
        if (head($data['list_sale'])>0){
            foreach ($data['list_sale'] as $val){
                $id_giay =$val->id_size;
                $data['list_size'][$id_giay] =[];
                $data['list_size'][$id_giay] =DB::table('tb_size')
                    ->where('id_giay','=',$id_giay)
                    ->get();
            }
        }

        return view('admin.quan-li-sale.list-sale',$data);
    }
    public  function ListGiayChuaSale(){
        $data['list_sale'] = DB::table('tb_giay')
            ->where('id_sale','=',1)
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->join('tb_loai_hang','tb_giay.id_loai_hang','=','tb_loai_hang.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram','tb_loai_hang.loai_hang')
            ->paginate(5);
        $data['total_sp']=DB::table('tb_giay')
            ->where('id_sale','=',1)
            ->get();
        $data['op_sale'] = DB::table('tb_sale')
            ->get();
        $data['view'] = 'chua_sale';

        //lấy id giày để lấy size
        if (head($data['list_sale'])>0){
            foreach ($data['list_sale'] as $val){
                $id_giay =$val->id_size;
                $data['list_size'][$id_giay] =[];
                $data['list_size'][$id_giay] =DB::table('tb_size')
                    ->where('id_giay','=',$id_giay)
                    ->get();
            }
        }

        return view('admin.quan-li-sale.list-sale',$data);
    }
    public function UpdateSale(Request $request){
        $id_sp = $request->get('id_sp');
        $id_sale = $request->get('id_sale');

        DB::table('tb_giay')
            ->Where('id','=',$id_sp)
            ->update(
                ['id_sale' => $id_sale]
            );

        return redirect(route('route_list_sale'))
            ->with(['succes_update'=>'Phần trăm sale đã được thay đổi !']);
    }
    public function ImportPermission()
    {
        $folder_controller = app_path('Http\Controllers');
//        echo $folder_controller;

        //1. Lấy danh sách file controller
        $listFile = scandir($folder_controller);

//        echo '<pre>';
//        print_r($listFile);

        $list_file_khong_import = ['Controller.php', '.', '..', 'Auth'];

        foreach ($listFile as $itemFileName) {
            if (in_array($itemFileName, $list_file_khong_import))
                continue;
            /// đọc nội dung file code để lấy tên hàm
            ///
            $ten_controller = str_replace('Controller.php', '', $itemFileName);

//            echo $ten_controller . '<br>';

            $file_full_path = $folder_controller . '/' . $itemFileName;
            $content = file_get_contents($file_full_path);

            preg_match_all('/public[ ]+function[ ]+(.*)[ ]*\(/', $content, $tra_ve_mang_ten_ham);
//            print_r($tra_ve_mang_ten_ham);
            echo '<hr>';

            // duyệt mảng tên hàm, ghép chuỗi thành tên permission, cái nào có trong
            // bảng permission rồi thì không thêm, cái nào chưa có thì thêm vào
            $stt = 0;
            foreach ($tra_ve_mang_ten_ham[1] as $ten_ham) {
                $stt ++;
                $ten_pms = $ten_controller . '.' . $ten_ham;
                echo "<br><b>".$stt.")</b>Ten PMS: " . $ten_pms;

                // kiểm tra chuỗi này có trong bảng permission chưa, nếu chưa thì thêm vào csdl.
                // phần này tự làm....
                $result = DB::table('tb_permission')
                    ->where('name', '=', $ten_pms)
                    ->first();

                //kiểm tra tự động thêm pms vào db---tồn tại rồi thì thông báo
                if (is_null($result)) {

                    $dataInsert['name'] = $ten_pms;
                    DB::table('tb_permission')->insert(
                        ['name' => $dataInsert['name']]
                    );

                } else {
                    // Already favorited - delete the existing
                    echo '_____Đã Được Thêm Vào DB______';
                }



            }


        }
        return redirect(route('route_list_permission'))
            ->with(['succes'=>'Cập Nhật Danh Sách Quyền Thành Công !']);
    }
    public function AddRoleId(){
        return view('admin.role.add-role');
    }
    public function SaveRoleId(Request $request){
        $checkRules = [
            'name'=>'required'
        ];

        $messages = [
            'name.required'=>'Bạn chưa nhập vai trò mới',
        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        $id = $request->get('id');
        if ($resValidate->fails()) {
            return redirect(route('route_AddRoleId'))
                ->withErrors($resValidate)
                ->withInput();
        }
        //đến đoạn này là thành công
        //hàm dưới này là để mã hóa password

        $dataInsert = [];
        $dataInsert['name'] = $request->get('name');//là id cuat thành viên

        $resInsert = DB::table('tb_role')
            ->insertGetId($dataInsert);
        return redirect(route('route_AddRoleId'))
            ->with(['succes'=>'Thêm mới vai trò thành công '.$resInsert]);
    }


}
