<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private $tableName = "calls";
    private $comment = "Tabla que almacena los registros de llamadas";

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            # Restricción UNIQUE para la idempotencia
            $table->string('call_id', 100)->unique();

            # Index para busquedas mas rapidas
            $table->string('phone_number', 20)->index();

            $table->string('agent', 100);
            $table->unsignedInteger('duration')->default(0);
            $table->string('recording_url', 500);

            $table->boolean('has_called_before')->default(false);
            $table->boolean('is_spam')->default(false);

            $table->timestamps();

            $table->comment($this->comment);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
