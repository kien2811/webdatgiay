<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KyGuiController extends Controller{
    function KyGuiGiay(){
        if (empty(Auth::check())){
            return redirect(route('login'))
                ->with(['yeu_cau_dn'=>'Bạn phải đăng nhập tài khoản !']);
        }
        $data['list_size'] = DB::table('tb_size')->select('size')->get();
        $data['list_loai_hang'] = DB::table('tb_loai_hang')->get();

        return view('kyguigiay.ky-gui-giay',$data);
    }
    function SaveKyGui(Request $request){


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
            //kiểm tra ảnh
            'anh_sp'=>'required',
            'anh_mt_01'=>'required',
            'anh_mt_02'=>'required',
            'anh_mt_03'=>'required',
            'anh_mt_04'=>'required',

            //kiểm tra thông tin giày lưu vào bảng ký gửi
            'name_giay'=>'required',
            'id_loai_hang'=>'required|exists:tb_loai_hang,id',
            'price'=>'required|regex:/^[0-9]{1,1000}$/',
            'thuong_hieu'=>'required',

            //kiểm tra thông tin lưu vào bảng mô tả
            'time_da_sd'=>'required',
            'mota'=>'required',

            //kiểm tra thông tin và lưu vào bảng khách hàng
            'full_name'=>'required',
            'phone'=>'required|regex:/^[0-9]{9,30}$/',
            'address'=>'required',
        ];
        $messages = [
            //kiểm tra ảnh
            'anh_sp.required'=>'Bạn cần thêm ảnh feedback !',
            'anh_mt_01.required'=>'Bạn cần thêm ảnh mô tả 1 !',
            'anh_mt_02.required'=>'Bạn cần thêm ảnh mô tả 2 !',
            'anh_mt_03.required'=>'Bạn cần thêm ảnh mô tả 3 !',
            'anh_mt_04.required'=>'Bạn cần thêm ảnh mô tả 4 !',

            //kiểm tra thông tin giày lưu vào bảng ký gửi
            'name_giay.required'=>'Bạn cần thêm Tên sản phẩm !',
            'id_loai_hang.exists'=>'Bạn phải chọn loại hàng !',
            'price.regex'=>'Giá chỉ được nhập số !',
            'price.required'=>'Bạn cần nhập giá !',
            'thuong_hieu.required'=>'Bạn cần nhập thương hiệu !',

            //kiểm tra thông tin lưu vào bảng mô tả
            'time_da_sd.required'=>'Bạn nhập thời gian đã sử dụng !',
            'mota.required'=>'Bạn cần Thêm mô tả sản phẩm !',

            //kiểm tra thông tin và lưu vào bảng khách hàng
            'full_name.required'=>'Bạn cần nhập đúng họ tên !',
            'phone.required'=>'Bạn cần nhập đúng sđt !',
            'address.required'=>'Bạn cần nhập địa chỉ !'
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
            $dataCustormerKgui['address']=$request->get('address');

            $id_customer_kygui = DB::table('tb_customer_kygui')->insertGetId($dataCustormerKgui);

            if (isset($id_customer_kygui)){
                $data['file_path_anh_sp']=$request->file('anh_sp')->store('public/anh-sp-kygui');
                $data['file_anh_sp']= $request->file('anh_sp')->getClientOriginalName();

                //sửa link ảnh
                $data['file_path_anh_sp'] = str_replace('public/','',$data['file_path_anh_sp']);


                $dataKgui = [];
                $dataKgui['name'] = $request->get('name_giay');
                $dataKgui['price'] = $request->get('price');
                $dataKgui['id_loai_hang'] = $request->get('id_loai_hang');
                $dataKgui['image'] = $data['file_path_anh_sp'];
                $dataKgui['id_trang_thai'] = 3; //là trạng thái đang Xử lý;
                $dataKgui['id_user'] = Auth::user()->id; //id tài khoản
                $dataKgui['time'] = date('Y-m-d H:i:s');
                $dataKgui['id_mota_kygui'] = $id_mota_kygui;
                $dataKgui['id_customer_kygui'] = $id_customer_kygui;
                $dataKgui['thuonghieu'] = $request->get('thuong_hieu');

                $idGiay = DB::table('tb_ky_gui')->insertGetId($dataKgui);
                if (isset($idGiay)){
                    DB::table('tb_ky_gui')
                        ->where('id','=',$idGiay)
                        ->update(
                            ['id_size' => $idGiay]
                        );

                    if (!empty( $request->get('sz_35') && $request->get('qtt_35')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_35');
                        $dataSize['quantity'] = $request->get('qtt_35');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_36') && $request->get('qtt_36')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_36');
                        $dataSize['quantity'] = $request->get('qtt_36');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_37') && $request->get('qtt_37')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_37');
                        $dataSize['quantity'] = $request->get('qtt_37');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_38') && $request->get('qtt_38')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_38');
                        $dataSize['quantity'] = $request->get('qtt_38');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_39') && $request->get('qtt_39')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_39');
                        $dataSize['quantity'] = $request->get('qtt_39');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_40') && $request->get('qtt_40')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_40');
                        $dataSize['quantity'] = $request->get('qtt_40');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_41') && $request->get('qtt_41')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_41');
                        $dataSize['quantity'] = $request->get('qtt_41');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_42') && $request->get('qtt_42')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_42');
                        $dataSize['quantity'] = $request->get('qtt_42');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_43') && $request->get('qtt_43')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_43');
                        $dataSize['quantity'] = $request->get('qtt_43');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }

                    if (!empty( $request->get('sz_44') && $request->get('qtt_44')>0)){
                        $dataSize['id'] = $idGiay;
                        $dataSize['size'] = $request->get('sz_44');
                        $dataSize['quantity'] = $request->get('qtt_44');

                        DB::table('tb_size_ky_gui')->insert(
                            ['id_giay' => $dataSize['id'],
                                'size' =>  $dataSize['size'],
                                'phan_loai_giay' =>  'giày ký gửi',
                                'quantity' => $dataSize['quantity'],
                            ]);
                    }
                    return redirect(route('route_ky_gui'))->with(['succes'=>'Gửi Sản Phẩm Thành Công, Cảm ơn quý khách']);
                }

            }
        }




    }

}
