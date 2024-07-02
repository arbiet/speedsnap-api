<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_types_name', 'service_provider_id'
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
