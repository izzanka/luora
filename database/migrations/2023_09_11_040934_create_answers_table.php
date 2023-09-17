<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Question::class);
            $table->text('answer');
            $table->string('image')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('total_views')->unsigned()->default(0);
            $table->bigInteger('total_upvotes')->unsigned()->default(0);
            $table->bigInteger('total_downvotes')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
