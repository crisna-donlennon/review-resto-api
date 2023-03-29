<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Resto;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            // foreignIdFor untuk menandai setiap reviews adalah milik User
            // 'user_id' = nama kolom
            // cascadeOnDelete apabila User/Resto dihapus, maka semua data yg bersangkutan dengan nya akan ikut dihapus
            $table->id();
            $table->text('text', 750);
            $table->unsignedInteger('rating')->default(0);
            $table->timestamps();
            $table->foreignIdFor(User::class, 'user_id')->cascadeOnDelete();
            $table->foreignIdFor(Resto::class, 'resto_id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
