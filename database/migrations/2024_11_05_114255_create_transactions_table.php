<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateTransactionsTable extends Migration
    {
        public function up()
        {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->decimal('montant_envoyer', 15, 2);
                $table->decimal('montant_recu', 15, 2);
                $table->enum('type_transaction', ['depot', 'retrait']);
                $table->enum('statut', ['effectué', 'annulé'])->default('annulé');
                $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('recever_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('transactions');
        }


        
    }
