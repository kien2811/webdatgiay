<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
//Auth::routes();
//
//Route::get('/', 'HomeController@index')->name('home');
//
//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::match(['get', 'post'], '/', 'IndexController@Index')->name('home_trang_chu');

//link đăng ký
Route::get('user/add', 'UserController@ShowFormAd')->name('route_add_user');
Route ::post('user/save-new-user', 'UserController@SaveNew')->name('route_save_new_user');

//link đăng nhập
Route::get('/logout', 'Auth\LoginController@Logout')->name('route_logout');


//link đến trang gửi giày
Route ::get('/ky-gui-giay.html', 'KyGuiController@KyGuiGiay')->name('route_ky_gui');
Route ::post('/save-ky-gui', 'KyGuiController@SaveKyGui')->name('route_save_ky_gui');


//link trang feedback sản phẩm cho
//Route ::get('feed-back.html', 'SanPhamController@FeedBack')->name('route_feedback');
Route ::post('save-feed-back', 'SanPhamController@SaveFeedBack')->name('route_save_feedback');

//link trang chi tiết sản phẩm
Route::match(['get', 'post'], 'chi-tiet-sp', 'SanPhamController@ChiTietSp')->name('route_chi_tiet');
Route::match(['get', 'post'], 'chi-tiet-sp-kg', 'SanPhamController@ChiTietSpKG')->name('route_chi_tiet_kg');

//Route ::get('chi-tiet-sp-kg', 'SanPhamController@ChiTietSpKG')->name('route_chi_tiet_kg');
//link trang giỏ hàng
Route ::post('save-cart', 'CartController@SaveCart')->name('route_save_cart');
Route ::get('show-cart', 'CartController@ShowCart')->name('route_show_cart');
Route ::get('delete-cart', 'CartController@DeleteCart')->name('route_delete_cart');
Route ::post('update-cart', 'CartController@UpdateCart')->name('route_update_cart');

//link gửi đơn hàng
Route ::get('oder-san-pham', 'OderController@Oder')->name('route_oder');
Route ::post('check-oder-san-pham', 'OderController@CheckOder')->name('route_check_oder');

//link Theo Dõi đơn hàng
Route ::get('theo-doi-don-hang', 'GiayController@SubDh')->name('route_theo_doi_dh');
Route ::post('huy-don-hang', 'GiayController@HuyDh')->name('route_huy_dh');


//link xem sản phẩm
Route::get('/danh-sach-san-pham', 'GiayController@ListGiay')->name('route_list_giay');
//link xem sản phẩm nam
Route::get('/danh-sach-san-pham-nam', 'GiayController@SPNam')->name('route_list_giay_nam');
//link xem sản phẩm nữ
Route::get('/danh-sach-san-pham-nu', 'GiayController@SPNu')->name('route_list_giay_nu');
//link xem sản phẩm ký gửi
Route::get('/danh-sach-san-pham-ky-gui', 'GiayController@SPKgui')->name('route_list_giay_ky_gui');
//link xem sản phẩm sale
Route::get('/danh-sach-san-pham-giam-gia', 'GiayController@SPSale')->name('route_list_giay_ky_sale');

//link tìm kiếm
Route::get('/search', 'LiveSearchController@search')->name('route_search');
Route::get('/search-permission', 'LiveSearchController@SearchPermission');
Route::get('/search-san-pham', 'LiveSearchController@SearchSpAdmin');
Route::get('/search-user', 'LiveSearchController@searchUser');



//backend-------------------------------------------------------------------------------

//link trang thêm sản phẩm cho admin
Route ::get('admin/add-giay', 'AdminController@FormAddGiay')
    ->name('route_add_giay')
    ->middleware('can:Admin.FormAddGiay');

Route ::post('book/save-new-giay', 'AdminController@SaveNewGiay')
    ->name('route_save_new_giay')
    ->middleware('can:Admin.SaveNewGiay');
//-------danh sách sản phẩm admin
Route::get('admin/list-san-pham','AdminController@ListSanPham')
    ->name('route_list_san_pham_admin')
    ->middleware('can:Admin.ListSanPham');
//--------Sửa Sản phẩm
Route::get('admin/list-san-pham/update','AdminController@UpdateSanpham')
    ->name('route_update_san_pham_admin')
    ->middleware('can:Admin.UpdateSanpham');
Route::post('admin/list-san-pham/up-date','AdminController@UpSanPham')
    ->name('route_up_date_san_pham_admin')
    ->middleware('can:Admin.UpSanPham');
//--------Sửa form Size Giày
Route::get('admin/list-size-san-pham/update','AdminController@FormUpdateSize')
    ->name('route_update_size_san_pham_admin')
    ->middleware('can:Admin.FormUpdateSize');
//------link xóa size
Route::post('admin/delete-size-san-pham/up-date','AdminController@deleteSize')
    ->name('route_delete_size_san_pham_admin')
    ->middleware('can:Admin.deleteSize');
//------link thêm size
Route::post('admin/add-size-san-pham/up-date','AdminController@AddSize')
    ->name('route_add_size_san_pham_admin')
    ->middleware('can:Admin.AddSize');
//-------------Xóa Sản phẩm
Route::get('admin/list-san-pham/delete','AdminController@deleteSanPham')
    ->name('route_delete_san_pham_admin')
    ->middleware('can:Admin.deleteSanPham');



//link trang kiểm duyệt sản phẩm ký gửi cho admin
Route ::get('/admin-duyet-ky-gui', 'AdminController@DuyetKyGui')
    ->name('route_list_ky_gui')
    ->middleware('can:Admin.DuyetKyGui');
//link xóa sản phẩm ký gửi
Route::match(['get', 'post'], '/admin-duyet-ky-gui/delete', 'AdminController@DeleteKyGui')
    ->name('route_delete_ky_gui')
    ->middleware('can:Admin.DeleteKyGui');
//link trang kiểm duyệt sản phẩm chưa xử lý
Route ::get('/admin-duyet-ky-gui-chua-xu-ly', 'AdminController@DuyetKyGuiChuaXl')
    ->name('route_list_ky_gui_chua_xl')
    ->middleware('can:Admin.DuyetKyGuiChuaXl');
//link trang kiểm duyệt sản phẩm đã nhận hàng
Route ::get('/admin-duyet-ky-gui-da-nhan', 'AdminController@DuyetKyGuiDaNhan')
    ->name('route_list_ky_gui_da_nhan')
    ->middleware('can:Admin.DuyetKyGuiDaNhan');

//link Sửa sản phẩm ký gửi
//Route::match(['get', 'post'], '/admin-duyet-ky-gui/update', 'AdminController@UpDaTe')->name('route_update_ky_gui');
Route ::match(['get', 'post'],'/admin-duyet-ky-gui/update', 'AdminController@UpDaTe')
    ->name('route_update_ky_gui')
    ->middleware('can:Admin.UpDaTe');
//Route::match(['get', 'post'], '/admin-duyet-ky-gui/saveupdate', 'AdminController@SaveUpDaTe')
//->name('route_save_update_ky_gui');
Route ::post('/admin-duyet-ky-gui/saveupdate', 'AdminController@SaveUpDaTe')
    ->name('route_save_update_ky_gui')
    ->middleware('can:Admin.SaveUpDaTe');

//link quản lí sale
Route ::get('/admin-sale', 'AdminController@ListSale')
    ->name('route_list_sale')
    ->middleware('can:Admin.ListSale');
//link quản xử lý phần trăm sale
Route ::post('/admin-update-sale', 'AdminController@UpdateSale')
    ->name('route_update_sale')
    ->middleware('can:Admin.UpdateSale');
//link đến giày đã giảm giá
Route ::get('/admin-sale/giay-sale', 'AdminController@ListGiaySale')
    ->name('route_list_giay_sale')
    ->middleware('can:Admin.ListGiaySale');
//link đến giày chưa giảm giá
Route ::get('/admin-sale/giay-chua-sale', 'AdminController@ListGiayChuaSale')
    ->name('route_list_giay_chua_sale')
    ->middleware('can:Admin.ListGiayChuaSale');

//link quản lý đơn hàng
Route::get('/admin/quan-ly-don-hang','AdminController@QuanLyDh')
    ->name('route_quan_ly_dh_admin')
    ->middleware('can:Admin.QuanLyDh');
Route::post('/admin/quan-ly-don-hang-update','AdminController@QuanLyUpdateDh')
    ->name('route_quan_ly_dh_update_admin')
    ->middleware('can:Admin.QuanLyUpdateDh');
//link xem chi tiết đơn hàng
Route::get('/admin/quan-ly-don-hang/chi-tiet','AdminController@DetailDh')
    ->name('route_quan_ly_dh_chi_tiet_admin')
    ->middleware('can:Admin.DetailDh');
//link đến đơn hàng chưa xử lý
Route::get('/admin/quan-ly-don-hang-chua-xu-ly','AdminController@QuanLyDhChuaXl')
    ->name('route_quan_ly_dh_admin_chua_xl')
    ->middleware('can:Admin.QuanLyDhChuaXl');
//link đến đơn hàng đã xử lý
Route::get('/admin/quan-ly-don-hang-da-xu-ly','AdminController@QuanLyDhDaXl')
    ->name('route_quan_ly_dh_admin_da_xl')
    ->middleware('can:Admin.QuanLyDhDaXl');

//trang quản trị - admin ---------------------------------------------------


Route::get('/admin','AdminController@index')
    ->name('route_index_admin')
    ->middleware('can:Admin.Index');

Route::get('/admin/listuser','AdminController@listUser')
    ->name('route_list_user')
    ->middleware('can:Admin.listUser');

Route::match(['get', 'post'],'/admin/UpdateRoleUser','AdminController@UpdateRoleUser')
    ->name('route_UpdateRoleUser')
    ->middleware('can:Admin.UpdateRoleUser');

Route::post('/admin/UpdatePmsUser','AdminController@UpdatePmsUser')
    ->name('route_UpdatePmsUser')
    ->middleware('can:Admin.UpdatePmsUser');

//Trang quản trị ------ User
Route::get('/admin/listuser','AdminController@listUser')
    ->name('route_list_user')
    ->middleware('can:Admin.listUser');
//-------------Thêm
Route::get('/admin/show-add-user','AdminController@ShowAddUser')
    ->name('route_show_add_user')
    ->middleware('can:Admin.ShowAddUser');
//-------------Xử lý thêm User
Route::post('/admin/add-user','AdminController@AddUser')
    ->name('route_add_user_admin')
    ->middleware('can:Admin.AddUser');
//-----------xóa
Route::get('admin/delete-user','AdminController@DeleteUser')
    ->name('route_delete_user')
    ->middleware('can:Admin.DeleteUser');



// Phân Quyền
//tìm kiếm tài khoản cho vào quyền
Route::post('/admin/seach-role-permission','AdminController@Seach_role')
    ->name('route_seach_role')
    ->middleware('can:Admin.Seach_role');
//danh sách phân quyền
Route::get('/admin/list-role-permission','AdminController@ListPmsRole')
    ->name('route_list_role_pms')
    ->middleware('can:Admin.ListPmsRole');
//link thêm phân quyền
Route::get('/admin/add-role-permission','AdminController@AddPmsRole')
    ->name('route_add_role_pms')
    ->middleware('can:Admin.AddPmsRole');
Route::post('/admin/add-save-role-permission','AdminController@AddSavePmsRole')
    ->name('route_add_save_role_pms')
    ->middleware('can:Admin.AddSavePmsRole');
//----xóa phân quyền
Route::get('admin/delete-role-permission','AdminController@DeletePmsRole')
    ->name('route_delete_role_pms')
    ->middleware('can:Admin.DeletePmsRole');

//---danh sách quyền
Route::get('/admin/list-permission','AdminController@ListPermission')
    ->name('route_list_permission')
    ->middleware('can:Admin.ListPermission');

//link inport Controler.Action vào bảng permision
Route::get('admin/import-permission','AdminController@ImportPermission')
    ->name('route_import_permission')
    ->middleware('can:Admin.ImportPermission');

//link thêm vai trò trang
Route::get('admin/AddRoleId','AdminController@AddRoleId')
    ->name('route_AddRoleId')
    ->middleware('can:Admin.AddRoleId');
Route::post('admin/SaveRoleId','AdminController@SaveRoleId')
    ->name('route_SaveRoleId')
    ->middleware('can:Admin.SaveRoleId');
//------------------------------------------------------------
//http://localhost/blog/public/xin-chao

