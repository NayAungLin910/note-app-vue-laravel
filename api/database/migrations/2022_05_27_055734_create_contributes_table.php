<?php

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'contributor_id');
            $table->foreignIdFor(User::class, 'contributed_id');
            $table->foreignIdFor(Note::class, 'note_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributes');
    }
}
