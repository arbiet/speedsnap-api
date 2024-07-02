<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name', 
        'price', 
        'download_speed', 
        'upload_speed', 
        'FUP', 
        'free_extra_quota', 
        'downgrade_speed', 
        'devices', 
        'IP_dynamic', 
        'IP_public', 
        'modem', 
        'service_provider_id'
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
