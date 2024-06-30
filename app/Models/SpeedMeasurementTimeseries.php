<?php

// app/Models/SpeedMeasurementTimeseries.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedMeasurementTimeseries extends Model
{
    use HasFactory;

    protected $fillable = [
        'speed_measurement_id', 'timestamp', 'download_speed', 'upload_speed', 'jitter', 'packet_loss', 'ping', 'latency'
    ];

    public function speedMeasurement()
    {
        return $this->belongsTo(SpeedMeasurement::class, 'speed_measurement_id');
    }
}
