<?php

namespace App\Providers;

use App\Role;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('admin', function (User $user) {
            return $user->role->name == Role::ADMIN;
        });
        Gate::define('manager', function (User $user) {
            return $user->role->name == Role::MANAGER;
        });
        Gate::define('reviewer', function (User $user) {
            return $user->role->name == Role::REVIEWER;
        });
        Gate::define('user', function (User $user) {
            return $user->role->name == Role::USER;
        });

    }
}
