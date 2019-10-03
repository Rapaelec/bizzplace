<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableImmobilier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immobiliers', function (Blueprint $table) {
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
            $table->string('nom')->nullable();
            $table->string('prix')->nullable();
            $table->string('pays')->nullable();
            $table->string('etat')->nullable();
            $table->string('ville')->nullable();
            $table->string('etage')->nullable();
            $table->string('piece')->nullable();
            $table->string('charge')->nullable();
            $table->string('chambre')->nullable();
            $table->string('terrain')->nullable();
            $table->string('surface')->nullable();
            $table->string('departement')->nullable();
            $table->string('chauffage')->nullable();
            $table->text('description')->nullable();
            $table->string('autre_info')->nullable();
            $table->string('type_offre')->nullable();
            $table->string('salle_de_bain')->nullable();
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
        Schema::dropIfExists('immobiliers');
    }
}
