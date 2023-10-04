<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objects_subcategories', function (Blueprint $table) {
            $table->foreign(['object_id'])->references(['id'])->on('objects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['subcategory_id'])->references(['id'])->on('subcategories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects_subcategories', function (Blueprint $table) {
            $table->dropForeign('objects_subcategories_object_id_foreign');
            $table->dropForeign('objects_subcategories_subcategory_id_foreign');
        });
    }
};
