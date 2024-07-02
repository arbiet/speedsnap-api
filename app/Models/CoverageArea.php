<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'city', 'state', 'service_provider_id'
    ];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
}
