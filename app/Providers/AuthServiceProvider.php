<?php

namespace App\Providers;


use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // ===Thêm phân quyền ở đây !!
        //=========== thêm phân quyền =========================
        if(!$this->app->runningInConsole()){
            // không phải ứng dụng chạy trong cửa sổ lệnh thì mới thực hiện kiểm tra
            foreach (Permission::all() as $_pms){
                Gate::define($_pms->name, function ($user) use ($_pms) {
                    return $user->hasPermission($_pms);
                });
            }
        }
        //==================================================
    }
}
