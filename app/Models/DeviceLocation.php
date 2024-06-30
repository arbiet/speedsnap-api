<?php

// app/Models/DeviceLocation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'latitude', 'longitude', 'road','district', 'city', 'state', 'country', 'speed_measurement_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
