<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class LiveSearchController extends Controller
{
    function index()
    {
        $data['products'] = DB::table('tb_giay')->get();
        return view('search.search',$data);
    }

    function search(Request $request)
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
            if ($request->search == '') {
                return('Bạn chưa nhập bất kỳ từ khóa nào');
            }
            return Response($output);
        }
    }
    function SearchPermission(Request $request)
    {
        {
            if ($request->ajax()) {
                $output = '';
                $products = DB::table('tb_permission')
                    ->where('name', 'LIKE', '%' . $request->search . '%')->get();
                if ($products) {
                    foreach ($products as $key => $product) {
                        $output .= '<tr>
                            <td>
                                <a href=" '.route('route_update_permission').'?id='.$product->id.' ">
                                    <button id="update">Update  <i class="fa fa-wrench" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <a href="'.route('route_delete_permission').'?id='.$product->id.'" onclick="return stop()">
                                    <button id="delete">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </td>
                            <td>'.$product->id.'</td>
                            <td><b>'.$product->name.'</b></td>
                        </tr>';
                    }
                }
                $products2 = $products = DB::table('tb_permission')->where('id', 'LIKE', '%' . $request->search . '%')->get();
                if ($products2) {
                    foreach ($products2 as $key => $product) {
                        $output .= '<tr>
                            <td>
                                <a href=" '.route('route_update_permission').'?id='.$product->id.' ">
                                    <button id="update">Update  <i class="fa fa-wrench" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <a href="'.route('route_delete_permission').'?id='.$product->id.'" onclick="return stop()">
                                    <button id="delete">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </td>
                            <td><b>'.$product->id.'</b></td>
                            <td>'.$product->name.'</td>
                        </tr>';
                    }
                }
                if ($request->search == '') {
                    return('Bạn chưa nhập bất kỳ từ khóa nào');
                }
                return Response($output);
            }
        }
    }
    function SearchSpAdmin(Request $request){
        {
            if ($request->ajax()) {
                $output = '';
                $products = DB::table('tb_giay')
                    ->join('tb_loai_hang','tb_loai_hang.id','=','tb_giay.id_loai_hang')
                    ->join('users','users.id','=','tb_giay.uid')
                    ->join('tb_gender','tb_gender.id','=','tb_giay.id_gender')
                    ->select('tb_giay.*','tb_loai_hang.loai_hang','users.email','tb_gender.gender')
                    ->where('tb_giay.name', 'LIKE', '%' . $request->search . '%')
                    ->get();
                if ($products) {
                    foreach ($products as $key => $product) {
                        $output .= '<tr>
                                <td>
                                    '.$product->id.'
                                </td>
                                <td>
                                    <img width="80" src="'.asset('/storage/'.$product->image).'">
                                </td>
                                <td>
                                    <a href="'.route('route_update_san_pham_admin').'?id='.$product->id.'">
                                        <b>'.$product->name.'</b>
                                    </a>
                                </td>
                                <td>
                                    '.number_format($product->price).' đ
                                </td>
                                <td>
                                    <a href="'.route('route_update_size_san_pham_admin').'?id='.$product->id.'">
                                    </a>

                                </td>
                                <td>
                                    '.$product->loai_hang.'
                                </td>
                                <td>
                                    '.$product->thuonghieu.'
                                </td>
                                <td>
                                    '.$product->gender.'
                                </td>
                                <td>
                                    '.$product->email.'
                                </td>
                                <td>
                                    <a href="'.route('route_chi_tiet').'?id='.$product->id.'" target="_blank" title="xem chi tiết">
                                        <button class="btn btn-warning" >Xem chi tiết</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="'.route('route_delete_san_pham_admin').'?id='.$product->id_mota.'" onclick="return stop()">
                                        <button class="btn btn-danger">Delete<i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>';
                    }
                }
                $products2 = $products = DB::table('tb_giay')
                    ->join('tb_loai_hang','tb_loai_hang.id','=','tb_giay.id_loai_hang')
                    ->join('users','users.id','=','tb_giay.uid')
                    ->join('tb_gender','tb_gender.id','=','tb_giay.id_gender')
                    ->select('tb_giay.*','tb_loai_hang.loai_hang','users.email','tb_gender.gender')
                    ->where('tb_giay.price', 'LIKE', '%' . $request->search . '%')->get();
                if ($products2) {
                    foreach ($products2 as $key => $product) {
                        $output .= '<tr>
                                <td>
                                    '.$product->id.'
                                </td>
                                <td>
                                    <img width="80" src="'.asset('/storage/'.$product->image).'">
                                </td>
                                <td>
                                    <a href="'.route('route_update_san_pham_admin').'?id='.$product->id.'">
                                        <b>'.$product->name.'</b>
                                    </a>
                                </td>
                                <td>
                                    <b>'.number_format($product->price).' đ</b>
                                </td>
                                <td>
                                    <a href="'.route('route_update_size_san_pham_admin').'?id='.$product->id.'">
                                    </a>

                                </td>
                                <td>
                                    '.$product->loai_hang.'
                                </td>
                                <td>
                                    '.$product->thuonghieu.'
                                </td>
                                <td>
                                    '.$product->gender.'
                                </td>
                                <td>
                                    '.$product->email.'
                                </td>
                                <td>
                                    <a href="'.route('route_chi_tiet').'?id='.$product->id.'" target="_blank" title="xem chi tiết">
                                        <button class="btn btn-warning" >Xem chi tiết</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="'.route('route_delete_san_pham_admin').'?id='.$product->id_mota.'" onclick="return stop()">
                                        <button class="btn btn-danger">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>';
                    }
                }
                $products3 = $products = DB::table('tb_giay')
                    ->join('tb_loai_hang','tb_loai_hang.id','=','tb_giay.id_loai_hang')
                    ->join('users','users.id','=','tb_giay.uid')
                    ->join('tb_gender','tb_gender.id','=','tb_giay.id_gender')
                    ->select('tb_giay.*','tb_loai_hang.loai_hang','users.email','tb_gender.gender')
                    ->where('tb_giay.thuonghieu', 'LIKE', '%' . $request->search . '%')
                    ->get();
                if ($products3) {
                    foreach ($products3 as $key => $product) {
                        $output .= '<tr>
                                <td>
                                    '.$product->id.'
                                </td>
                                <td>
                                    <img width="80" src="'.asset('/storage/'.$product->image).'">
                                </td>
                                <td>
                                    <a href="'.route('route_update_san_pham_admin').'?id='.$product->id.'">
                                        <b>'.$product->name.'</b>
                                    </a>
                                </td>
                                <td>
                                    '.number_format($product->price).' đ
                                </td>
                                <td>
                                    <a href="'.route('route_update_size_san_pham_admin').'?id='.$product->id.'">
                                    </a>

                                </td>
                                <td>
                                    '.$product->loai_hang.'
                                </td>
                                <td>
                                    <b>'.$product->thuonghieu.'</b>
                                </td>
                                <td>
                                    '.$product->gender.'
                                </td>
                                <td>
                                    '.$product->email.'
                                </td>
                                <td>
                                    <a href="'.route('route_chi_tiet').'?id='.$product->id.'" target="_blank" title="xem chi tiết">
                                        <button class="btn btn-warning" >Xem chi tiết</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="'.route('route_delete_san_pham_admin').'?id='.$product->id_mota.'" onclick="return stop()">
                                        <button class="btn btn-danger">Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>';
                    }
                }
                if ($request->search == '') {
                    return('Bạn chưa nhập bất kỳ từ khóa nào');
                }
                return Response($output);
            }
        }

    }
    function searchUser(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $products = DB::table('users')
                ->where('id', 'LIKE', '%' . $request->search . '%')->get();
            if ($products) {
                foreach ($products as $key => $product) {
                    $output .= '<tr>
                                <td>
                                    <a href="'.route('route_delete_user').'?id='.$product->id.'" onclick="return stop()">
                                        <button class="btn btn-danger" >Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <b>'.$product->id.'</b>
                                </td>
                                <td>
                                    '.$product->name.'
                                </td>
                                <td>
                                    '.$product->email.'
                                </td>
                            </tr>';
                }
            }
            $products2 = $products = DB::table('users')
                ->where('name', 'LIKE', '%' . $request->search . '%')->get();
            if ($products2) {
                foreach ($products2 as $key => $product) {
                    $output .= '<tr>
                                <td>
                                    <a href="'.route('route_delete_user').'?id='.$product->id.'" onclick="return stop()">
                                        <button class="btn btn-danger" >Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    '.$product->id.'
                                </td>
                                <td>
                                    <b>'.$product->name.'</b>
                                </td>
                                <td>
                                    '.$product->email.'
                                </td>
                            </tr>';
                }
            }
            $products3 = $products = DB::table('users')
                ->where('email', 'LIKE', '%' . $request->search . '%')->get();
            if ($products3) {
                foreach ($products3 as $key => $product) {
                    $output .= '<tr>
                                <td>
                                    <a href="'.route('route_delete_user').'?id='.$product->id.'" onclick="return stop()">
                                        <button class="btn btn-danger" >Delete <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    '.$product->id.'
                                </td>
                                <td>
                                    '.$product->name.'
                                </td>
                                <td>
                                    <b>'.$product->email.'</b>
                                </td>
                            </tr>';
                }
            }
            if ($request->search == '') {
                return('Bạn chưa nhập bất kỳ từ khóa nào');
            }
            return Response($output);
        }
    }

}
