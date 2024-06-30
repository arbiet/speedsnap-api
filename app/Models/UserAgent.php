<?php

// app/Models/UserAgent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'user_agent',  'speed_measurement_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
