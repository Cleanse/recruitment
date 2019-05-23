<?php

namespace Cleanse\Recruitment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddInitialRecruitmentTables extends Migration
{
    public function up()
    {
        Schema::create('cleanse_recruitment_teams', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('datacenter');
            $table->text('contact_method');
            $table->text('description');
            $table->json('availability');
            $table->boolean('recruiting')->default(false);
            $table->timestamps();
        });

        Schema::create('cleanse_recruitment_players', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('server');
            $table->string('datacenter');
            $table->string('slug');
            $table->json('roles');
            $table->text('contact_method');
            $table->text('profile');
            $table->boolean('recruited')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cleanse_recruitment_players');
        Schema::dropIfExists('cleanse_recruitment_teams');
    }
}
