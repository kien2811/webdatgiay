<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KyGuiController extends Controller{
    public function KyGuiGiay(){
        $data['list_size'] = DB::table('tb_size')->select('size')->get();
        $data['list_loai_hang'] = DB::table('tb_loai_hang')->get();

        return view('kyguigiay.ky-gui-giay',$data);
    }
    public function SaveKyGui(Request $request){
        $checkRules = [
            //kiểm tra ảnh
            'anh_sp'=>'required',
            'anh_mt_01'=>'required',
            'anh_mt_02'=>'required',
            'anh_mt_03'=>'required',
            'anh_mt_04'=>'required',

            //kiểm tra thông tin giày lưu vào bảng ký gửi
            'name_giay'=>'required',
            'size'=>'required|exists:tb_size,size',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
            'price'=>'required|regex:/^[0-9]{1,1000}$/',
            'thuong_hieu'=>'required',

            //kiểm tra thông tin lưu vào bảng mô tả
            'time_da_sd'=>'required',
            'mota'=>'required',

            //kiểm tra thông tin và lưu vào bảng khách hàng
            'full_name'=>'required',
            'phone'=>'required|regex:/^[0-9]{9,30}$/',
        ];
        $messages = [
            //kiểm tra ảnh
            'anh_sp.required'=>'Bạn cần Thêm ảnh feedback',
            'anh_mt_01.required'=>'Bạn cần Thêm ảnh mô tả 1',
            'anh_mt_02.required'=>'Bạn cần Thêm ảnh mô tả 2',
            'anh_mt_03.required'=>'Bạn cần Thêm ảnh mô tả 3',
            'anh_mt_04.required'=>'Bạn cần Thêm ảnh mô tả 4',

            //kiểm tra thông tin giày lưu vào bảng ký gửi
            'name_giay.required'=>'Bạn cần Thêm Tên sản phẩm',
            'size.exists'=>'Bạn phải chọn loại size',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng',
            'price.required'=>'Bạn cần nhập giá và chỉ nhập số',
            'thuong_hieu.required'=>'Bạn cần nhập thương hiệu',

            //kiểm tra thông tin lưu vào bảng mô tả
            'time_da_sd.required'=>'Bạn nhập thời gian đã sử dụng',
            'mota.required'=>'Bạn cần Thêm mô tả sản phẩm',

            //kiểm tra thông tin và lưu vào bảng khách hàng
            'full_name.required'=>'Bạn cần nhập đúng họ tên',
            'phone.required'=>'Bạn cần đúng sđt',
        ];

        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_ky_gui'))
                ->withErrors($resValidate)
                ->withInput();
        }
        //đưa hình ảnh vào thư mục
        $data['file_path_anh_mt_01']=$request->file('anh_mt_01')->store('public/anh-mota-sp-kygui');
        $data['file_anh_mt_01']= $request->file('anh_mt_01')->getClientOriginalName();

        $data['file_path_anh_mt_02']=$request->file('anh_mt_02')->store('public/anh-mota-sp-kygui');
        $data['file_anh_mt_02']= $request->file('anh_mt_02')->getClientOriginalName();

        $data['file_path_anh_mt_03']=$request->file('anh_mt_03')->store('public/anh-mota-sp-kygui');
        $data['file_anh_mt_03']= $request->file('anh_mt_03')->getClientOriginalName();

        $data['file_path_anh_mt_04']=$request->file('anh_mt_04')->store('public/anh-mota-sp-kygui');
        $data['file_anh_mt_04']= $request->file('anh_mt_04')->getClientOriginalName();

        //sửa link hình ảnh
        $data['file_path_anh_mt_01'] = str_replace('public/','',$data['file_path_anh_mt_01']);
        $data['file_path_anh_mt_02'] = str_replace('public/','',$data['file_path_anh_mt_02']);
        $data['file_path_anh_mt_03'] = str_replace('public/','',$data['file_path_anh_mt_03']);
        $data['file_path_anh_mt_04'] = str_replace('public/','',$data['file_path_anh_mt_04']);


        $dataMotaKgui = [];
        $dataMotaKgui['time_da_sd'] = $request->get('time_da_sd');
        $dataMotaKgui['noi_dung_mota'] = $request->get('mota');
        $dataMotaKgui['image_1'] = $data['file_path_anh_mt_01'];
        $dataMotaKgui['image_2'] = $data['file_path_anh_mt_02'];
        $dataMotaKgui['image_3'] = $data['file_path_anh_mt_03'];
        $dataMotaKgui['image_4'] = $data['file_path_anh_mt_04'];

        $id_mota_kygui = DB::table('tb_mota_kygui')->insertGetId($dataMotaKgui);

        if (isset($id_mota_kygui)){
            $dataCustormerKgui = [];
            $dataCustormerKgui['fullname']=$request->get('full_name');
            $dataCustormerKgui['phone']=$request->get('phone');

            $id_customer_kygui = DB::table('tb_customer_kygui')->insertGetId($dataCustormerKgui);

            if (isset($id_customer_kygui)){
                $data['file_path_anh_sp']=$request->file('anh_sp')->store('public/anh-sp-kygui');
                $data['file_anh_sp']= $request->file('anh_sp')->getClientOriginalName();

                //sửa link ảnh
                $data['file_path_anh_sp'] = str_replace('public/','',$data['file_path_anh_sp']);


                $dataKgui = [];
                $dataKgui['name'] = $request->get('name_giay');
                $dataKgui['price'] = $request->get('price');
                $dataKgui['size'] = $request->get('size');
                $dataKgui['id_loai_hang'] = $request->get('id_loai_hang');
                $dataKgui['image'] = $data['file_path_anh_sp'];
                $dataKgui['id_trang_thai'] = 3; //là trạng thái đang Xử lý;
                $dataKgui['id_user'] = 1;
                $dataKgui['time'] = date('Y-m-d H:i:s');
                $dataKgui['id_mota_kygui'] = $id_mota_kygui;
                $dataKgui['id_customer_kygui'] = $id_customer_kygui;
                $dataKgui['thuonghieu'] = $request->get('thuong_hieu');

                $reskgui = DB::table('tb_ky_gui')->insertGetId($dataKgui);
                return redirect(route('route_ky_gui'))->with(['succes'=>'Gửi Sản Phẩm Thành Công, Cảm ơn quý khách']);
            }
        }




    }
    public function FeedBack(){
        $data=[];
        $data['feedback'] = DB::table('users')
            ->join('tb_feedback','users.id','=','tb_feedback.uid')
            ->orderBy('tb_feedback.id','desc')
            ->get();
        return view('kyguigiay.feed-back',$data);
    }
    public function SaveFeedBack(Request $request){
        if (empty(Auth::check())){
            return redirect(route('login'))
                ->with(['yeu_cau_dn'=>'Bạn phải đăng nhập tài khoản !']);
        }
        $checkRules = [
            'file_anh'=>'required',
            'noi_dung'=>'required',
            'star'=>'required',
        ];
        $messages = [
            'file_anh.required'=>'Bạn cần Thêm ảnh feedback',
            'noi_dung.required'=>'Lời bạn muốn nói ?',
            'star.required'=>'Bạn phải chọn sao yêu thích',
        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($resValidate->fails()) {
            return redirect(route('route_feedback'))
                ->withErrors($resValidate)
                ->withInput();
        }

        $data['file_path_img_fb']=$request->file('file_anh')->store('public/anh-feedback');
        $data['file_img_fb']= $request->file('file_anh')->getClientOriginalName();
//        echo $data['file_path_img_fb'];
//        echo '<hr>';
        //sửa hình link hình ảnh
        $data['file_path_img_fb'] = str_replace('public/','',$data['file_path_img_fb']);
//        echo $data['file_path_img_fb'];

        $dataFeed =[];
        $dataFeed['image'] = $data['file_path_img_fb'];
        $dataFeed['noi_dung'] = $request->get('noi_dung');
        $dataFeed['so_sao'] = $request->get('star');
        $dataFeed['uid'] = Auth::user()->id;
        $dataFeed['time'] = date('Y-m-d H:i:s');

        $resFed = DB::table('tb_feedback')->insertGetId($dataFeed);
        return redirect(route('route_feedback'))->with(['succes'=>'ok']);

    }
}
