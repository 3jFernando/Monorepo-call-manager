<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Enums\CallStatus;

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

            $table->enum('status', [CallStatus::RINGING, CallStatus::IN_PROGRESS, CallStatus::COMPLETED, CallStatus::SPAM])
                ->default(CallStatus::RINGING)
                ->index();

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
