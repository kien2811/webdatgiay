<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SanPhamController extends Controller{
    public function FormAddGiay(){
        if (empty(Auth::check())){
            echo '<script>';
                echo 'confirm("bạn không có quyền truy cập")';
            echo '</script>';
            return redirect()->route('route_home');
        }

        $data['list_size'] = DB::table('tb_size')->select('id')->distinct()->get();
        $data['list_loai_hang'] = DB::table('tb_loai_hang')->get();

        return view('sanpham.add-san-pham',$data);
    }
    public function SaveNewGiay(Request $request){
        $checkRules = [
            //đoạn này xử lý cho phần thông tin sản phầm
            'name_giay'=>'required',
            'price_giay'=>'required|regex:/^[0-9]{1,1000}$/',
            'id_size'=>'required|exists:tb_size,id',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
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
            'name_giay.required'=>'Tên Giày không được để trống',
            'price_giay.required'=>'Giá Giày không được để trống và chỉ nhập số',
            'id_size.exists'=>'Bạn phải chọn loại size',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng',
            'thuong_hieu.required'=>'Thương hiệu không được trống',
            'file_anh.required'=>'Ảnh Giày không được trống',
            //phần này ghi lỗi của mô tả
            'cap_mo_ta.required'=>'Bạn Cần thêm Cap mô tả',
            'noi_dung_mo_ta.required'=>'Bạn Cần Nội dung mô tả',
            'mau_sac.required'=>'Bạn Cần thêm Màu sắc cho sản phẩm',
            'noi_sx.required'=>'Bạn Cần thêm Nơi Sản Xuất',
            'img_mt_01.required'=>'Bạn Cần thêm Ảnh mô tả 01',
            'img_mt_02.required'=>'Bạn Cần thêm Ảnh mô tả 02',
            'img_mt_03.required'=>'Bạn Cần thêm Ảnh mô tả 03',
            'img_mt_04.required'=>'Bạn Cần thêm Ảnh mô tả 04',

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
            $dataGiay['id_size'] = $request->get('id_size');
            $dataGiay['id_mota'] = $resmtGiay;
            $dataGiay['id_sale'] = 1;
            $dataGiay['id_loai_hang'] = $request->get('id_loai_hang');
            $dataGiay['image'] = $data['file_path_img_sp'];
            $dataGiay['uid'] = Auth::user()->id;
            $dataGiay['thuonghieu'] = $request->get('thuong_hieu');

            $resGiay = DB::table('tb_giay')->insertGetId($dataGiay);
            return redirect(route('route_add_giay'))->with(['msg'=>'Thêm mới thành công: id = '.$resGiay]);
        }

        $dataInsert['name_bk'] = $request->get('name_bk');
        $dataInsert['image'] =  $data['file_path'];

        return redirect(route('route_add_giay'));
        echo '<pre>';
        print_r($request->all());
    }
    public function ChiTietSp(){
        $id_sp =$_GET['id'];
        $data['chi_tiet'] = DB::table('tb_giay')
            ->where('tb_giay.id','=',$id_sp)
            ->join('tb_mota','tb_giay.id_mota','=','tb_mota.id')
            ->join('tb_loai_hang','tb_giay.id_loai_hang','=','tb_loai_hang.id')
            ->join('tb_size','tb_giay.id_size','=','tb_size.id')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_mota.*','tb_loai_hang.*','tb_size.*','tb_sale.sale_phan_tram')
            ->get();

//        tạo vòng lập để lấy id size và thương hiệu để truy vấn
        foreach ($data['chi_tiet'] as $val){
//            echo $val->thuonghieu;
        }
        //lấy size giày
        $id_size = $val->id_size;
        $data['list_size'] = DB::table('tb_size')->Where('id','=',$id_size)
            ->select('tb_size.size')
            ->get();
//        print_r($data['list_size']);

        //lấy sản phẩm liên quan
        $thuonghieu = $val->thuonghieu;
        $data['list_sp_lq'] = DB::table('tb_giay')
            ->Where('thuonghieu','=',$thuonghieu)
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();
//        print_r($data['list_sp_lq']);

        return view('sanpham.chi-tiet-sp',$data);
    }
    public function ChiTietSpKG(){
        $id_sp =$_GET['id'];
        $data['chi_tiet'] = DB::table('tb_ky_gui')->where('tb_ky_gui.id','=',$id_sp)
            ->join('tb_loai_hang','tb_ky_gui.id_loai_hang','=','tb_loai_hang.id')
            ->join('tb_mota_kygui','tb_ky_gui.id_mota_kygui','=','tb_mota_kygui.id')
            ->get();
        foreach ($data['chi_tiet'] as $val){
//            echo $val->thuonghieu;
        }
        $thuonghieu = $val->thuonghieu;
        $data['list_sp_lq'] = DB::table('tb_ky_gui')
            ->Where('thuonghieu','=',$thuonghieu)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('sanpham.chi-tiet-sp',$data);
    }
}
