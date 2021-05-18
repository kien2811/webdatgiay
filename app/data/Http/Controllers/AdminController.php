<?php
 namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller{
    public function Index(){
        $data['list_member'] = DB::table('users')->get();
        return view('admin.index',$data);
    }
    public function listUser(){
        $data['list_member'] = DB::table('users')->get();
        return view('admin.user.list-user',$data);
    }
    public function ShowAddUser(){

        return view('admin.user.show-add-user');
    }
    public function AddUser(Request $request){
        //kiểm tra dữ liệu
        //có 2 cách để kiểm tra
        //1 dùng trực tiếp trong controller
        //2. dùng lớp Requet riêng để kiểm tra hợp lệ dữ liệu
        //thiết lập hàm kiểm tra hợp lệ
        //https://laravel.com/docs/5.8/validation#available-validation-rules
        $checkRules = [
            'username'=>'required|regex:/^[a-zA-Z0-9]{5,30}$/|unique:users,username',
            'password'=>'required|min:6|confirmed',
            'password_confirmation' => 'required|required_with:password|same:password|min:6',
            'email'=>'required|email|unique:users,email',
            'id_role'=>'required|numeric'
        ];

        $messages = [
            'username.required'=>'Tên Đăng Nhập Không Đc Để Trống !',
            'password.required'=>'Mật Khẩu Không Đc Để Trống !',
            'password_confirmation.required'=>'Nhập lại mật Khẩu Không được bỏ Trống !',
            'password.confirmed'=>'Xác Nhận Mật Khẩu không Khớp',
            'email.required'=>'Email Không Đc Để Trống !',
            'id_role.required'=>'Bạn chưa chọn Quyền',

            'id_role.numeric'=>'Bạn chưa chọn Chọn Thành phần',
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
            return redirect(route('route_show_add_user'))
                ->withErrors($resValidate)
                ->withInput();
        }
        //đến đoạn này là thành công

        //hàm dưới này là để mã hóa password

        $password = Hash::make($request->get('password'));
        $dataInsert = [];
        $dataInsert['name'] = $request->get('username');
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
            ->orderBy('time','DESC')
            ->get();

        return view('admin.duyet-ky-gui.list-ky-gui',$data);
    }
    public function DeleteKyGui(){
        $id_kygui = $_GET['id'];
//        echo $id_kygui;
//        $blog = Blog::find($id_kygui);
//        Storage::delete($blog->image);
//        $blog->delete();
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
    public function UpDaTe(){
        $id_sp = $_GET['id'];
        $data['chi_tiet_sp'] = DB::table('tb_ky_gui')->where('tb_ky_gui.id','=',$id_sp)
            ->join('tb_mota_kygui', 'tb_ky_gui.id_mota_kygui', '=', 'tb_mota_kygui.id')
            ->join('tb_loai_hang', 'tb_ky_gui.id_loai_hang', '=', 'tb_loai_hang.id')
            ->get();
        $data['list_loai_hang']=  DB::table('tb_loai_hang')->get();
        $data['trang_thai']=  DB::table('tb_status')
            ->where('id','=',1)
            ->orwhere('id','=',2)
            ->get();
        return view('admin.duyet-ky-gui.update-ky-gui',$data);
    }
    public function SaveUpDaTe(Request $request){
        $id_sp = $_GET['id'];
        $checkRules = [
            'name'=>'required',
            'size'=>'required',
            'price'=>'required',
            'time_da_sd'=>'required',
            'thuonghieu'=>'required',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
            'id_trang_thai'=>'required|exists:tb_status,id',
        ];
        $messages = [
            'name.required'=>'Trường tên không được trống',
            'size.required'=>'Trường size không được trống và chỉ nhập số',
            'price.required'=>'Trường giá không được trống',
            'time_da_sd.required'=>'Phải có thời gian sử dụng',
            'thuonghieu.required'=>'Trường thương hiệu không đc trống',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng',
            'id_trang_thai.exists'=>'Bạn phải chọn Trạng Thái',
        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_update_ky_gui').'?id='.$id_sp)
                ->withErrors($resValidate)
                ->withInput();
        }
        if ($request->get('id_trang_thai')==2){//nếu từ chối hàng thì xóa luôn đơn hàng khỏi db
            return redirect(route('route_delete_ky_gui').'?id='.$id_sp);
        }
        $dataUp =[];
        $dataUp['name'] =$request->get('name');
        $dataUp['price'] = str_replace(',','',$request->get('price'));
        $dataUp['size'] =$request->get('size');
        $dataUp['id_loai_hang'] =$request->get('id_loai_hang');
        $dataUp['id_trang_thai'] =$request->get('id_trang_thai');
        $dataUp['thuonghieu'] =$request->get('thuonghieu');
        $dataUp['time_da_sd'] =$request->get('time_da_sd');


        DB::table('tb_ky_gui')
            ->Where('id','=',$id_sp)
            ->update(
                ['name' =>  $dataUp['name'],
                'price' => $dataUp['price'],
                'size' => $dataUp['size'],
                'id_loai_hang' => $dataUp['id_loai_hang'],
                'id_trang_thai' => $dataUp['id_trang_thai'],
                'thuonghieu' => $dataUp['thuonghieu'],
            ]);

        DB::table('tb_mota_kygui')
            ->Where('id','=',$id_sp)
            ->update(
            ['time_da_sd' => $dataUp['time_da_sd'],]
        );
         echo 'ok';

        return redirect(route('route_list_ky_gui'))->with(['succes_update'=>'Lưu Dữ Liệu Thành Công']);
    }
    public function QuanLyDh(){
        $data['list_dh'] = DB::table('tb_order')
            ->join('tb_customer','tb_order.id_customer','=','tb_customer.id')
            ->join('tb_status','tb_order.id_status','=','tb_status.id')
            ->select('tb_order.*','tb_customer.fullname','tb_customer.phone','tb_customer.address','tb_status.status')
            ->orderBy('time','desc')
            ->get();
        $data['list_status'] = DB::table('tb_status')
            ->where('id','=',6)
            ->orWhere('id','=',5)
            ->get();
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
        echo 'ok';

        return redirect(route('route_quan_ly_dh_admin'))
            ->with(['succes_update'=>'Trạng thái đã được thay đổi !']);
    }
    public function DetailDh(){
        $id_oder = $_GET['id'];
//        echo  $id_oder;
        $data['detail_oder'] = DB::table('tb_order_detail')
            ->where('id_order','=',$id_oder)
            ->get();
//        foreach ($data['detail_oder'] as $val){
//            if ($val->phan_loai_giay = 'sản phẩm new'){
//                $data['image']= DB::table('tb_giay')
//                    ->where('id','=',$val->id_giay)
//                    ->select('tb_giay.image')
//                    ->get();
//            }
//            if ($val->phan_loai_giay = 'sản phẩm ký gửi'){
//                $data['image']= DB::table('tb_ky_gui')
//                    ->where('id','=',$val->id_giay)
//                    ->select('tb_ky_gui.image')
//                    ->get();
//            }
//        }
//
//        print_r($data['image']);

        return view('admin.quan-ly-dh.detail-dh',$data);
    }
    public function Permission(){
        $data['permission'] = DB::table('role_permission')
            ->join('tb_role','role_permission.role_id','=','tb_role.id')
            ->join('tb_permission','tb_permission.id','=','role_permission.permission_id')
            ->get();
        return view('admin.permission.list-permission',$data);
    }
    public function AddPermission(){
        return view('admin.permission.add-permission');
    }
    public function SavePermission(Request $request){
        $checkRules = [
            'id_role'=>'required',
            'name_permission'=>'required',
        ];
        $messages = [
            'id_role.required'=>'Bạn chưa chọn Chọn Thành phần',
            'name_permission.required'=>'Bạn chưa nhập trường cho trang mới',
        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_add_permission'))
                ->withErrors($resValidate)
                ->withInput();
        }
        $dataInsert['name'] = $_POST['name_permission'];
        $resInsert = DB::table('tb_permission')->insertGetId($dataInsert);

        // lưu vào bảng role_permission
        $Insert['role_id'] = $_POST['id_role'];
        $Insert['permission_id'] = $resInsert;

        $Insertres = DB::table('role_permission')->insertGetId($Insert);


        return redirect(route('route_add_permission'))
            ->with(['succes'=>'Lưu Dữ Liệu Thành Công ID = ' .$Insertres]);
    }
    public function deletePermission(){
        if (!empty($_GET['id'])){
            $id_permission = $_GET['id'];
            DB::table('role_permission')
                ->where('permission_id', '=', $id_permission)
                ->delete();
            DB::table('tb_permission')
                ->where('id', '=', $id_permission)
                ->delete();

            return redirect(route('route_list_permission'))
                ->with(['succes'=>'Xóa Dữ Liệu Thành Công']);
        }
        else{
            return redirect(route('route_list_permission'));
        }

    }
    public function UpdatePermission(Request $request){
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $data['update'] = DB::table('tb_permission')
                ->where('id', '=', $id)->get();
            return view('admin.permission.update-permission', $data);
        }
    }
    public function UpPermission(Request $request){
        $checkRules = [
            'id_role'=>'required|numeric',
            'name_permission'=>'required',
        ];
        $messages = [
            'id_role.required'=>'Bạn chưa chọn Chọn Thành phần',
            'id_role.numeric'=>'Bạn chưa chọn Chọn Thành phần',
            'name_permission.required'=>'Bạn chưa nhập trường cho trang mới',
        ];
        $id = $request->id;
        $name['name'] = $request->name_permission;
        $role_permission['role_id'] = $request->id_role;
        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        print_r($id);
        if ($resValidate->fails()) {
            return redirect(route('route_update_permission').'?id='.$id)
                ->withErrors($resValidate)
                ->withInput();
        }
        $up = DB::table('role_permission')
            ->Where('permission_id','=',$id)
            ->update($role_permission);
        $resInsert = DB::table('tb_permission')
            ->Where('id','=',$id)
            ->update($name);

        return redirect(route('route_update_permission').'?id='.$id)
            ->with(['succes'=>'Cập nhật Dữ Liệu Thành Công']);
    }
    public function ListSanPham(){
        $data['list'] = DB::table('tb_giay')
            ->join('tb_loai_hang','tb_loai_hang.id','=','tb_giay.id_loai_hang')
            ->join('tb_mota','tb_mota.id','=','tb_giay.id_mota')
            ->join('users','users.id','=','tb_giay.uid')
            ->get();
        return view('admin.san-pham.list-san-pham-admin',$data);
    }
    public function UpdateSanpham(){
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $data['list'] = DB::table('tb_giay')
                ->where('tb_giay.id','=',$id)
                ->join('tb_loai_hang', 'tb_loai_hang.id', '=', 'tb_giay.id_loai_hang')
                ->join('tb_mota', 'tb_mota.id', '=', 'tb_giay.id_mota')
                ->join('users', 'users.id', '=', 'tb_giay.uid')
                ->get();
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
            'id_size'=>'required|exists:tb_size,id',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
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
            'id_size.exists'=>'Bạn phải chọn loại size',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng',
            'thuong_hieu.required'=>'Thương hiệu không được trống',
            //phần này ghi lỗi của mô tả
            'cap_mo_ta.required'=>'Bạn Cần thêm Cap mô tả',
            'noi_dung_mo_ta.required'=>'Bạn Cần Nội dung mô tả',
            'mau_sac.required'=>'Bạn Cần thêm Màu sắc cho sản phẩm',
            'noi_sx.required'=>'Bạn Cần thêm Nơi Sản Xuất',

        ];

        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        $id = $request->get('id_mota');
        if ($resValidate->fails()) {
            return redirect(route('route_update_san_pham_admin').'?id='.$id)
                ->withErrors($resValidate)
                ->withInput();
        }

        //đường dẫn file ảnh và tên ảnh sản phẩm
        $dataMtGiay['noi_dung_mota'] = $request->get('noi_dung_mo_ta');
        $dataMtGiay['mausac'] = $request->get('mau_sac');
        $dataMtGiay['cap_mo_ta'] = $request->get('cap_mo_ta');
        $dataMtGiay['noi_SX'] = $request->get('noi_sx');
        $idmota = $request->get('id_mota');
        $resmtGiay = DB::table('tb_mota')
            ->where('id','=',$idmota)
            ->Update($dataMtGiay);
        if (isset($resmtGiay)){
            $dataGiay = [];
            $idmota = $request->get('id_mota');
            $dataGiay['name'] = $request->get('name_giay');
            $dataGiay['price'] = $request->get('price_giay');
            $dataGiay['id_size'] = $request->get('id_size');
            $dataGiay['id_sale'] = 1;
            $dataGiay['id_loai_hang'] = $request->get('id_loai_hang');
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
    public function deleteSanPham(){
        if (!empty($_GET['id'])){
            $id_sp = $_GET['id'];
            $delete_mota = DB::table('tb_giay')
                ->where('id', '=', $id_sp)
                ->delete();
            if ($delete_mota) {
                DB::table('tb_mota')
                    ->where('id', '=', $id_sp)
                    ->delete();
                return redirect(route('route_list_san_pham_admin'))
                    ->with(['succes'=>'Xóa Dữ Liệu Thành Công']);
            }
        }
        else{
            return redirect(route('route_list_san_pham_admin'));
        }
    }



}
