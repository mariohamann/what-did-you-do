<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveInspirationsFromActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('inspirations_ancestors');
            $table->dropColumn('inspirations_descendants');
            $table->dropColumn('inspirations_children');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->json('inspirations_ancestors')->nullable();
            $table->json('inspirations_descendants')->nullable();
            $table->json('inspirations_children')->nullable();
        });
    }
}
