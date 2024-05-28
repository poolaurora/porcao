<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infos extends Model
{
    use HasFactory;

    protected $fillable = [
        'ccn', 'validade', 'cvv', 'senha6', 'nome', 'cpf', 'email', 'telefone', 'info', 'valor', 'limite', 'banco', 'genero', 'categoria', 'level', 'is_published'
    ];

    protected $casts = [
        'limite' => 'float',  // ou 'integer', dependendo da precisão necessária
    ];
    

    public function setCcnAttribute($value)
    {
        $this->attributes['ccn'] = trim($value);
    }

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function item()
{
    return $this->belongsTo(Item::class);
}
}
