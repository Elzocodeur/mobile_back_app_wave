<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['montant_envoyer', 'montant_recu', 'type_transaction', 'statut', 'sender_id', 'recever_id'];

    /**
     * Relation avec le modèle User pour l'expéditeur.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relation avec le modèle User pour le destinataire.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'recever_id');
    }
}
