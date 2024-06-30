<?php

// app/Models/DeviceLocation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'latitude', 'longitude', 'road', 'city', 'state', 'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
