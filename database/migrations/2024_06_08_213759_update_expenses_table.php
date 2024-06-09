<?php

use App\Enums\ExpenseStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('status')->default(ExpenseStatus::PENDING->value);
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('status');
        });

    }
};
