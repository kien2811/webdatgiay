<?php
 namespace App\Http\Controllers;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Cart;
session_start();

class CartController extends Controller{
         public function SaveCart(Request $request){

             if ($request->size == 'chọn size'){
                 echo '<script>';
                    echo 'alert("Yêu Cầu chọn size")';
                 echo '</script>';
                 echo '<script>';

                     echo 'window.history.back()';
                 echo '</script>';

                 return;
             }

             if (isset($request->producid_hidden)){
                 $producId = $request->producid_hidden;
                 $quantity = $request->quantity;
                 $size = $request->size;
//                 print_r($request->all());
//                 return;

                 $produc_info = DB::table('tb_giay')->where('tb_giay.id','=',$producId)
                     ->join('tb_size', 'tb_giay.id_size', '=', 'tb_size.id')
                     ->join('tb_loai_hang','tb_giay.id_loai_hang','=','tb_loai_hang.id')
                     ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
                     ->select('tb_giay.*', 'tb_size.size','tb_loai_hang.loai_hang','tb_sale.sale_phan_tram')
                     ->first();
            echo '<pre>';
                print_r($produc_info);
             echo '</pre>';
//             Cart::add('293ad', 'Product 1', 1, 9.99, 550);
//             Cart::destroy();
                 $data['id'] = $producId;
                 $data['qty'] = $quantity;
                 $data['name'] = $produc_info->name;

                 if ($produc_info->sale_phan_tram != 0){
                     $price_sale = $produc_info->price*($produc_info->sale_phan_tram/100);
                     $price_sale = $produc_info->price - $price_sale;
                     $data['price'] = $price_sale;
                 }
                 if ($produc_info->sale_phan_tram == 0){
                     $data['price'] = $produc_info->price;
                 }
                 $data['weight'] = '123';
                 $data['options']['image'] = $produc_info->image;
                 $data['options']['loai_hang'] = $produc_info->loai_hang;
                 $data['options']['size'] = $size;
                 $data['options']['phan_loai'] = 'sản phẩm new';

                 Cart::add($data);
                 return redirect(route('route_show_cart'));
             }
             if (isset($request->producid_hidden_kg)){
                 $producId = $request->producid_hidden_kg;
                 $quantity = $request->quantity;
                 $size = $request->size;
//                 print_r($request->all());
//                 return;

                 $produc_info = DB::table('tb_ky_gui')
                     ->where('tb_ky_gui.id','=',$producId)
                     ->join('tb_loai_hang','tb_ky_gui.id_loai_hang','=','tb_loai_hang.id')
                     ->select('tb_ky_gui.*','tb_loai_hang.loai_hang')
                     ->first();
//            echo '<pre>';
//                print_r($produc_info);
//             echo '</pre>';

//             Cart::add('293ad', 'Product 1', 1, 9.99, 550);
//             Cart::destroy();
                 $data['id'] = $producId;
                 $data['qty'] = $quantity;
                 $data['name'] = $produc_info->name;
                 $data['price'] = $produc_info->price;
                 $data['weight'] = '123';
                 $data['options']['image'] = $produc_info->image;
                 $data['options']['loai_hang'] = $produc_info->loai_hang;
                 $data['options']['size'] = $produc_info->size;
                 $data['options']['phan_loai'] = 'sản phẩm ký gửi';
                 Cart::add($data);
                 return redirect(route('route_show_cart'));
             }


         }
        public function ShowCart(){
            return view('cart.show-cart');
        }
        public function DeleteCart(){
             $rowId = $_GET['id'];
//             echo $rowId;
            Cart::update($rowId,0);
            return redirect(route('route_show_cart'));
        }
        public function updateCart(Request $request){
            $rowId = $request->id_update;
            $qty = $request->qty;

//            echo $rowId;
//            echo $qty;
            Cart::update($rowId,$qty);
            return redirect(route('route_show_cart'));
        }
     }
?>

