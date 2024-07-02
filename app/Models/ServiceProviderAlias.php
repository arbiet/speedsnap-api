<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProviderAlias extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_provider_id',
        'alias_name',
        'alias_org',
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
