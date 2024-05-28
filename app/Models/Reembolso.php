<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reembolso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'status',
        'chave_pix',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
