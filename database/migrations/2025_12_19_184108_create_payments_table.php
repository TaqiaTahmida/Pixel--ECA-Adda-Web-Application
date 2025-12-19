<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent')->nullable();

            $table->string('status')->default('pending'); 
            // pending | paid | failed

            $table->integer('amount'); // in BDT
            $table->string('currency')->default('bdt');
            $table->string('package_type'); // tier1 / tier2

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
?>