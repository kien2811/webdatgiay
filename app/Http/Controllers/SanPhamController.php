<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
session_start();
class SanPhamController extends Controller{

    function ChiTietSp(){

        if(isset($_GET['id'])){
            $id_sp =$_GET['id'];


            //lấy lươt truy cập sản phẩm ch
            if(!isset($_SESSION['view'])){
                $_SESSION['view']=[];
            }
            if(isset($_SESSION['view'][$id_sp])){
                $_SESSION['view'][$id_sp] ++;

                DB::table('tb_giay')
                    ->where('id','=',$id_sp)
                    ->update(['view'=>$_SESSION['view'][$id_sp]]);
            }
            else{
                $_SESSION['view'][$id_sp] = 1;
                DB::table('tb_giay')
                    ->where('id','=',$id_sp)
                    ->update(['view'=>$_SESSION['view'][$id_sp]]);
            }

            //lấy id sản phẩm cho vào cookie------------------
            $sp = @$_COOKIE[$id_sp];
            $arrSp =[];
            if (strlen($sp)>0){
                $arrSp = unserialize($sp);
            }
            $arrSp[] = $id_sp;
            $saveStr = serialize($arrSp);

            setcookie($id_sp, $saveStr, time() + 3600);

            $mang = $arrSp;
            $total = count($mang);
            $step = 0;
//            for ($i = $total-1; $i>0; $i--){
//                $step ++;
//                if ($step >=4) break;
//
//                echo '<pre>';
//                    print_r($_COOKIE[$id_sp]);
//            }
//            -------------------------------------------đăng mắc 1 đoạn


            $data['chi_tiet'] = DB::table('tb_giay')
                ->where('tb_giay.id','=',$id_sp)
                ->join('tb_mota','tb_giay.id_mota','=','tb_mota.id')
                ->join('tb_loai_hang','tb_giay.id_loai_hang','=','tb_loai_hang.id')
                ->join('tb_size','tb_giay.id_size','=','tb_size.id_giay')
                ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
                ->join('tb_gender','tb_giay.id_gender','=','tb_gender.id')
                ->select('tb_giay.*','tb_mota.*','tb_loai_hang.loai_hang',
                    'tb_size.size','tb_size.phan_loai_giay','tb_sale.sale_phan_tram','tb_gender.gender')
                ->get();
//        tạo vòng lập để lấy id size và thương hiệu để truy vấn
            foreach ($data['chi_tiet'] as $val){
//            echo $val->thuonghieu;
            }

            //lấy size giày
            $id_giay = $val->id_size;
            $data['list_size'] = DB::table('tb_size')
                ->Where('id_giay','=',$id_giay)
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

            //lấy danh sách sản phẩm đc feeback
            $data['total_fb'] = DB::table('tb_feedback')
                ->where('id_giay','=',$id_giay)
                ->get();
            $data['feedback'] = DB::table('tb_feedback')
                ->where('tb_feedback.id_giay' ,'=',$id_giay)
                ->join('users','users.id','=','tb_feedback.uid')
                ->orderBy('tb_feedback.id','desc')
                ->select('tb_feedback.*','users.name')
                ->paginate(5);

            return view('sanpham.chi-tiet-sp',$data);
        }
    }
    function ChiTietSpKG(){
        if(isset($_GET['id'])){
            $id_sp =$_GET['id'];
            $data['chi_tiet'] = DB::table('tb_ky_gui')
                ->where('tb_ky_gui.id','=',$id_sp)
                ->join('tb_loai_hang','tb_ky_gui.id_loai_hang','=','tb_loai_hang.id')
                ->join('tb_mota_kygui','tb_ky_gui.id_mota_kygui','=','tb_mota_kygui.id')
                ->join('tb_size_ky_gui','tb_ky_gui.id','=','tb_size_ky_gui.id_giay')
                ->select('tb_ky_gui.*','tb_loai_hang.loai_hang'
                    ,'tb_mota_kygui.*','tb_size_ky_gui.*')
                ->get();
            foreach ($data['chi_tiet'] as $val){
//            echo $val->thuonghieu;
            }
//            echo '<pre>';
//            print_r($data['chi_tiet']);
//            return;
            //lấy size giày
            $id_giay = $val->id_size;
            $data['list_size'] = DB::table('tb_size_ky_gui')
                ->Where('id_giay','=',$id_giay)
                ->get();

            $thuonghieu = $val->thuonghieu;
            $data['list_sp_lq'] = DB::table('tb_ky_gui')
                ->Where('thuonghieu','=',$thuonghieu)
                ->orderBy('id', 'desc')
                ->take(4)
                ->get();

            //lấy danh sách sản phẩm đc feeback
            $data['total_fb'] = DB::table('tb_feedback')
                ->where('id_giay','=',$id_giay)
                ->get();
            $data['feedback'] = DB::table('tb_feedback')
                ->where('tb_feedback.id_giay' ,'=',$id_giay)
                ->join('users','users.id','=','tb_feedback.uid')
                ->orderBy('tb_feedback.id','desc')
                ->select('tb_feedback.*','users.name')
                ->paginate(5);

            return view('sanpham.chi-tiet-sp',$data);
        }
    }

    function SaveFeedBack(Request $request){
        if (empty(Auth::check())){
            return redirect(route('login'))
                ->with(['yeu_cau_dn'=>'Bạn phải đăng nhập tài khoản !']);
        }
        $id_giay = $request->get('id_giay');

        $checkRules = [
            'star'=>'required',
        ];
        $messages = [
            'star.required'=>'Bạn phải chọn sao yêu thích',
        ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);

        if ($request->get('phan_loai_giay') =='giày mới'){
            if ($resValidate->fails()) {
                return redirect(route('route_chi_tiet').'?id='.$id_giay)
                    ->withErrors($resValidate)
                    ->withInput();
            }
        }

        if (!empty($request->file('file_anh'))){
            $data['file_path_img_fb']=$request->file('file_anh')->store('public/anh-feedback');
            $data['file_img_fb']= $request->file('file_anh')->getClientOriginalName();
//        echo $data['file_path_img_fb'];
//        echo '<hr>';
            //sửa hình link hình ảnh
            $data['file_path_img_fb'] = str_replace('public/','',$data['file_path_img_fb']);
//        echo $data['file_path_img_fb'];
            $dataFeed['image'] = $data['file_path_img_fb'];
        }


        $dataFeed['noi_dung'] = $request->get('noi_dung');
        $dataFeed['so_sao'] = $request->get('star');
        $dataFeed['uid'] = Auth::user()->id;
        $dataFeed['time'] = date('Y-m-d H:i:s');
        $dataFeed['id_giay'] = $id_giay;
        $dataFeed['phan_loai_giay']=$request->get('phan_loai_giay');

        $resFed = DB::table('tb_feedback')->insertGetId($dataFeed);
        if ($request->get('phan_loai_giay') == 'giày mới' ){
            return redirect(route('route_chi_tiet').'?id='.$id_giay)
                ->with(['succes'=>'Đánh Giá Thành Công !']);
        }
        if ($request->get('phan_loai_giay') == 'giày ký gửi' ){
            return redirect(route('route_chi_tiet_kg').'?id='.$id_giay)
                ->with(['succes'=>'Đánh Giá Thành Công !']);
        }

    }
}
