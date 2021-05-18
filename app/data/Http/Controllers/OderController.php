<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Cart;

class OderController extends Controller{
    public function Oder(){
        if (empty(Auth::check())){
            return redirect(route('route_show_login'))
                ->with(['yeu_cau_dn'=>'Bạn phải đăng nhập tài khoản !']);
        }
        if (Cart::count() == 0){
            return redirect(route('route_show_cart'))
                ->with(['gio_hang_trong'=>'Bạn phải có sản phẩm trong giỏ hàng!']);
        }
        return view('oder-san-pham.show-oder');
    }
    public function CheckOder(Request $request){

        $checkRules = [
           //gắn thông tin khách hàng vào hàm request để kiểm tra
            'full_name'=>'required',
            'phone'=>'required|regex:/^[0-9]{1,1000}$/',
            'email'=>'required',
            'Tinh_TP'=>'required',
            'Quan_huyen'=>'required',
            'Dia_chi'=>'required',
//            'mess'=>'required',
            ];
        $messages = [
            //phần lỗi thông tin sản phẩm
            'full_name.required'=>'Họ tên không được trống !',
            'phone.required'=>'SĐT không được trống và chỉ nhập số',
            'email.required'=>'Email không được trống !',
            'Tinh_TP.required'=>'Tỉnh - TP không được trống !',
            'Quan_huyen.required'=>'Quận - Huyện không được trống !',
            'Dia_chi.required'=>'Địa chỉ không được trống !',
//            'mess.required'=>'Họ tên không được trống !',
            ];
        $resValidate = Validator::make($request->all(), $checkRules,$messages);
        if ($resValidate->fails()) {
            return redirect(route('route_oder'))
                ->withErrors($resValidate)
                ->withInput();
        }
        //lưu dữ liệu vào tb_khách hàng
        $dataCustor =[];
        $dataCustor['fullname'] = $request->full_name;
        $dataCustor['phone'] = $request->phone;
        $dataCustor['address'] = $request->Dia_chi.'/'.$request->Quan_huyen.'/'.$request->Tinh_TP;
        $dataCustor['email'] = $request->email;
        $dataCustor['uid'] = Auth::user()->id;
        $dataCustor['mess'] = $request->mess;
        //        echo '<pre>';
        //        print_r($dataCustor);
        $idCustor = DB::table('tb_customer')->insertGetId($dataCustor);
        if (isset($idCustor)){
            $dataOder = [];
            $dataOder['id_customer'] = $idCustor;
            $dataOder['time'] = date('Y-m-d H:i:s');
            $dataOder['id_status'] = 3;//cho vào trạng thái đang xử lý
            $idOder = DB::table('tb_order')->insertGetId($dataOder);

            if (isset($idOder)){
                //                echo '<pre>';
//        print_r($dataOder);
//        echo '<pre>';
//            print_r(Cart::content());
//        echo '</pre>';
                $dataOderDetail = [];
                foreach (Cart::content() as $item){
                    if ($item->options->phan_loai =='sản phẩm new'){
                        $dataOderDetail['id_order'] = $idOder;
                        $dataOderDetail['id_giay'] = $item->id;
                        $dataOderDetail['quantity'] = $item->qty;
                        $dataOderDetail['price'] = $item->price;
                        $dataOderDetail['phan_loai_giay'] = $item->options->phan_loai;
                        $idOderDetail = DB::table('tb_order_detail')->insertGetId($dataOderDetail);
                    }
                    if ($item->options->phan_loai =='sản phẩm ký gửi'){
                        $dataOderDetail['id_order'] = $idOder;
                        $dataOderDetail['id_giay'] = $item->id;
                        $dataOderDetail['quantity'] = $item->qty;
                        $dataOderDetail['price'] = $item->price;
                        $dataOderDetail['phan_loai_giay'] = $item->options->phan_loai;
                        $idOderDetail = DB::table('tb_order_detail')->insertGetId($dataOderDetail);

                    }
//                    echo '<pre>';
//                    print_r($dataOderDetail);
//                    echo '</pre>';

                }
                return redirect(route('route_oder'))
                    ->with(['gui_don_tc'=>'Đơn hàng đã được gửi. Cảm ơn Quý Khách!']);

            }

        }

    }
}
