<?php

namespace App\Providers;

use App\Models\Permession;
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

        $permessions = Permession::all();
        $hasPermession = false;
        foreach ($permessions as $perm) {
            Gate::define($perm['key'], function(User $user) use($perm, $hasPermession) {
                if($user->type == 'admin') {
                    $hasPermession = true;
                } else {
                    foreach ($user->roles as $role) {
                        if($role->permessions->contains('key', $perm['key'])) {
                            $hasPermession = true;
                        }
                    }
                }
                return $hasPermession;
            });
        }
    }
}
