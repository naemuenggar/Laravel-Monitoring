<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringData extends Model
{
    use HasFactory;

    protected $table = 'monitoring_data';

    protected $fillable = [
        'name',
        'category',
        'description',
        'status',
        'quantity',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'integer',
    ];
}
