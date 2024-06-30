<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternetServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_type',
        'ip',
        'district',
        'city',
        'region',
        'country',
        'loc',
        'org',
        'timezone',
        'speed_measurement_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function speedMeasurements()
    {
        return $this->hasMany(SpeedMeasurement::class, 'isp_id');
    }
}
