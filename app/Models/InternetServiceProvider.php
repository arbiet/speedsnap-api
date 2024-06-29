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
        'city',
        'region',
        'country',
        'loc',
        'org',
        'timezone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
