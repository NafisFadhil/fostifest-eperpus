<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
				Gate::define('superadmin', function($user) {
						return $user->role->code == 'SUPADMIN';
				});
				Gate::define('admin', function($user) {
						return $user->role->code == 'GURU';
				});
				Gate::define('siswa', function($user) {
						return $user->role->code == 'MEMBER';
				});
    }
}
