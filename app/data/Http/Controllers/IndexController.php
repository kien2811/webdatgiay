<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller{
    public function Index(){
        $data['list_sp_hot'] =DB ::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->take(4)->get();
        $data['list_sp_new'] =DB ::table('tb_giay')
            ->join('tb_sale','tb_giay.id_sale','=','tb_sale.id')
            ->select('tb_giay.*','tb_sale.sale_phan_tram')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();
        $data['list_sp_ky_gui'] =DB ::table('tb_ky_gui')
            ->where('id_trang_thai','=',1)
            ->orderBy('id', 'desc')
            ->take(4)->get();
        return view('index',$data);
    }
}
