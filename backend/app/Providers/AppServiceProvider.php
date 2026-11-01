<?php

namespace App\Providers;

use App\Models\CompanySetting;
use App\Models\Material;
use App\Policies\CompanySettingPolicy;
use App\Policies\MaterialPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use App\Models\Client;
use App\Policies\ClientPolicy;

class AppServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Material::class        => MaterialPolicy::class,
        CompanySetting::class  => CompanySettingPolicy::class,
        Client::class         => ClientPolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
