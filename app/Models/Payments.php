<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'status', 'pix_code_url', 'description'
    ];

    protected $casts = [
        'description' => 'array',
    ];
}
