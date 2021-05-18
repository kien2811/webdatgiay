<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class LiveSearchController extends Controller
{
    public function index()
    {
        $data['products'] = DB::table('tb_giay')->get();
        return view('search.search',$data);
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $products = DB::table('tb_giay')->where('name', 'LIKE', '%' . $request->search . '%')->get();
            if ($products) {
                foreach ($products as $key => $product) {
                    $output .= '<tr>
                        <td><a href="'.route('route_chi_tiet').'?id='.$product->id.'"><b>' . $product->name . '</b></a></td>
                        <td>' . $product->price . '</td>
                        <td><img style="width: 100px; height: 100px"  class="col-12 col-md-12" src="'.asset('/storage/'.$product->image).'"></td>
                    </tr>';
                }
            }
            $products2 = $products = DB::table('tb_giay')->where('price', 'LIKE', '%' . $request->search . '%')->get();
            if ($products2) {
                foreach ($products2 as $key => $product) {
                    $output .= '<tr>
                     <td><a href="'.route('login').'"><b>' . $product->name . '</b></a></td>
                    <td><b>' . $product->price . '</b></td>
                    <td><img style="width: 100px; height: 100px" class="col-12 col-md-12" src="http://localhost/Do-an-2019/blog/storage/app/' . $product->image . '"></td>
                    </tr>';
                }
            }
            if ($request->search == ''){
                return null;
            }
            return Response($output);
        }
    }
}
