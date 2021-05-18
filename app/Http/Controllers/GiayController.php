<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GiayController extends Controller{
    function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            print_r($$request->name);
            if ($request->name < 1000000) {
                $products = DB::table('tb_giay')->where('price', '<', '1000000')->get();
                print_r($products);
                foreach($products as $a => $sp)
                     echo           '<div class="col-6 col-md-4">
                                    <div id="san-pham">
                                        <img class="col-12 col-md-12" src="http://localhost/Do-an-2019/blog/storage/app/'.$sp->image.'">
                                        <li><a href="">'.$sp->name.'</a></li>
                                        <li><a href="">'.number_format($sp->price).'đ</a></li>
                                        <input type="button" name="" value="MUA">
                                    </div>
                                </div>';
            }
            if ($request->search == ''){
                return null;
            }
            return Response($output);
        }
    }
    function ListGiay(){
        $data = [];
        $data['mingia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','ASC')->take(1)->get();
        $data['maxgia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','DESC')->take(1)->get();

        $data['allsp'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->get();
        $data['list'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->paginate(12);
        $data['phan_loai'] = 'all';

        if(head($data['list'])==0){
            return redirect(route('home_trang_chu'));
        }
        return view('giay.list-giay',$data);
    }
    function SPNam(){
        $data = [];
        $data['mingia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','ASC')->take(1)->get();
        $data['maxgia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','DESC')->take(1)->get();

        $data['allsp'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->get();
        $data['list'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->where('id_gender','=',1)
            ->paginate(12);
        $data['phan_loai'] = 'men';
        if(head($data['list'])==0){
            return redirect(route('home_trang_chu'));
        }
        return view('giay.list-giay',$data);
    }
   function SPNu(){
        $data = [];
        $data['mingia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','ASC')->take(1)->get();
        $data['maxgia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','DESC')->take(1)->get();

        $data['allsp'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->get();
        $data['list'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->where('id_gender','=',2)
            ->paginate(12);
        $data['phan_loai'] = 'woman';
        if(head($data['list'])==0){
            return redirect(route('home_trang_chu'));
        }
        return view('giay.list-giay',$data);
    }
    function SPKgui(){
        $data = [];
        $data['mingia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','ASC')->take(1)->get();
        $data['maxgia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','DESC')->take(1)->get();

        $data['allsp'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->get();
        $data['list'] = DB::table('tb_ky_gui')
            ->paginate(12);
        $data['phan_loai'] = 'kgui';
        if(head($data['list'])==0){
            return redirect(route('home_trang_chu'));
        }
        return view('giay.list-giay',$data);
    }
    function SPSale(){
        $data = [];
        $data['mingia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','ASC')->take(1)->get();
        $data['maxgia'] = DB::table('tb_giay')->select('price')
            ->orderBy('price','DESC')->take(1)->get();

        $data['allsp'] = DB::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->get();
        $data['list'] = DB::table('tb_giay')
            ->Where('id_sale','!=','1')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->where('id_sale','>',0)
            ->paginate(12);
        $data['phan_loai'] = 'sale';
        if(head($data['list'])==0){
            return redirect(route('home_trang_chu'));
        }
        return view('giay.list-giay',$data);
    }

    function SubDh(){
        if (empty(Auth::check())){
            return redirect(route('login'))
                ->with(['yeu_cau_dn'=>'Bạn phải đăng nhập tài khoản !']);
        }
        $id_cus = Auth::user()->id;
        $data['don_hang'] = DB::table('tb_order')
        ->where('uid','=',$id_cus)
        ->join('tb_customer','tb_order.id_customer','=','tb_customer.id')
        ->join('tb_status','tb_order.id_status','=','tb_status.id')
        ->select('tb_order.*','tb_customer.uid','tb_status.status')
        ->orderBy('tb_order.id','desc')
        ->get();
//        echo '<pre>';
//        print_r($data['don_hang']);
//        echo '</pre>';
            $data['sub_dh_sl']['soluong'] =[];
            $data['sub_dh_tg']['tonggia'] =[];
        foreach ($data['don_hang'] as $val){

            $id_oder = $val->id;

            $data['sub_dh_sl']['soluong'][$val->id] =[];
            $data['sub_dh_tg']['tonggia'][$val->id] =[];

            $data['detail_oder'] = DB::table('tb_order_detail')
                ->where('id_order','=',$id_oder)
                ->get();
//            echo '<pre>';
//            print_r($data['detail_oder']);
//            echo '</pre>';
            $qty =0;
            $tong_gia =0;
            $price =0;
            foreach ($data['detail_oder'] as $val_dt) {
                if (strcmp($val_dt->id_order,$val_dt->id_order) ==0){
                    $qty += $val_dt->quantity;
                    $price = $val_dt->quantity * $val_dt->price;
                    $tong_gia += $price;
                }

            }

            $data['sub_dh_sl']['soluong'][$val->id] =$qty;
            $data['sub_dh_tg']['tonggia'][$val->id] =$tong_gia;
        }


        return view('giay.theo-doi-don-hang',$data);
    }
    function HuyDh(Request $request){
        $id = $request->get('id');
        $status = $request->get('status');

        if ($status =='Đang Xử Lý'){

            DB::table('tb_order')
                ->Where('id','=', $id)
                ->update(['id_status' =>4]);
            return redirect(route('route_theo_doi_dh'))
                ->with(['huy_tc_tb'=>'Hủy đơn hàng thành công !']);
        }
        else{
            return redirect(route('route_theo_doi_dh'))
                ->with(['huy_tb'=>'Xin lỗi không thể hủy đơn hàng !']);
        }
    }
}
