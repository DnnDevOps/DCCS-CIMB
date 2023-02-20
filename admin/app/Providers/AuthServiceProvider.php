<?php

namespace ObeliskAdmin\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use ObeliskAdmin\Admin;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'ObeliskAdmin\Model' => 'ObeliskAdmin\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->before(function (Admin $admin, $ability) {
            return $admin->username == 'admin' ? true : ( $ability == 'manage-settings' ? false : $admin->role->permitted($ability));
        });
    }
}
