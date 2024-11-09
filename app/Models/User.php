<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable  // Changé de Model à Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'telephone',
        'password',
        'email',
        'cni',
        'date_naissance',
        'nom',
        'prenom',
        'qrcode',
        'statut_compte'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->hasOne(Client::class);
    }

    public function transactionsSent()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function transactionsReceived()
    {
        return $this->hasMany(Transaction::class, 'recever_id');
    }
}
