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
        Schema::create('objects_subcategories', function (Blueprint $table) {
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('subcategory_id')->index('objects_subcategories_subcategory_id_foreign');

            $table->primary(['object_id', 'subcategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objects_subcategories');
    }
};
