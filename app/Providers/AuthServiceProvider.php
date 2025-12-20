<?php

namespace App\Providers;

use App\Models\Camp;
use App\Policies\CampPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Camp::class => CampPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
