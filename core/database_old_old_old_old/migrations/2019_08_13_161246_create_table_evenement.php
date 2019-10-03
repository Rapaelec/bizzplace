<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEvenement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('vendor_id');
            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('vendors')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unsignedInteger('subcategory_id');
            $table->foreign('subcategory_id')
                  ->references('id')
                  ->on('subcategories')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('image');
            $table->string('pays')->nullable();
            $table->string('rue')->nullable();
            $table->string('ville')->nullable();
            $table->string('siret')->nullable();
            $table->string('type')->nullable();
            $table->string('enseigne')->nullable();
            $table->string('site_racv')->nullable();
            $table->string('site_existant')->nullable();
            $table->text('description_short')->nullable();
            $table->text('description_long')->nullable();
            $table->string('raison_social')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('departement')->nullable();
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
        Schema::dropIfExists('evenements');
    }
}
