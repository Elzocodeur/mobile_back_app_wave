<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementMarchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'marchand_id',
        'montant',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function marchand()
    {
        return $this->belongsTo(User::class, 'marchand_id');
    }
}
