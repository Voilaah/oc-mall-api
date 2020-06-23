<?php namespace Voilaah\MallApi\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateApiSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('voilaah_mallapi_api_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('voilaah_mallapi_api_settings');
    }
}
