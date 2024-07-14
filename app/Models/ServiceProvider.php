<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name', 'address', 'contact_number', 'email', 'website', 'customer_support_hours', 'installation_fee'
    ];

    public function coverageAreas()
    {
        return $this->hasMany(CoverageArea::class);
    }

    public function planDetails()
    {
        return $this->hasMany(PlanDetail::class);
    }

    public function serviceTypes()
    {
        return $this->hasMany(ServiceType::class);
    }

    public function aliases()
    {
        return $this->hasMany(ServiceProviderAlias::class);
    }
    public function internetServiceProviders()
    {
        return $this->hasMany(InternetServiceProvider::class, 'org', 'provider_name');
    }
}
