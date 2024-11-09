<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'role_id' , 'surename'];

    /**
     * Relation avec le modèle User
     * Un client est lié à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le modèle Role.
     * Un client possède un rôle (par exemple, client, admin, distributeur).
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Transactions envoyées par le client.
     */
    public function transactionsSent()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    /**
     * Transactions reçues par le client.
     */
    public function transactionsReceived()
    {
        return $this->hasMany(Transaction::class, 'recever_id');
    }
}
