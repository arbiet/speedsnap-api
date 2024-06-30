<?php

// app/Models/SpeedMeasurement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'isp_id', 'user_id', 'download_speed', 'upload_speed', 'jitter', 'packet_loss', 'ping', 'latency'
    ];

    public function isp()
    {
        return $this->belongsTo(InternetServiceProvider::class, 'isp_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeseries()
    {
        return $this->hasMany(SpeedMeasurementTimeseries::class, 'speed_measurement_id');
    }
}
