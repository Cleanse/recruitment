<?php

namespace Cleanse\Recruitment\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddInitialRecruitmentTables extends Migration
{
    public function up()
    {
        Schema::create('cleanse_recruitment_players', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('region');
            $table->json('roles');
            $table->text('availability');
            $table->text('contact_method');
            $table->boolean('recruited')->default(false);
            $table->timestamps();
        });

        Schema::create('cleanse_recruitment_teams', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('region');
            $table->text('availability');
            $table->text('contact_method');
            $table->boolean('recruited')->default(false);
            $table->timestamps();
        });

        Schema::create('cleanse_recruitment_player_team', function($table)
        {
            $table->integer('player_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->primary(['player_id', 'team_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cleanse_recruitment_player_team');
        Schema::dropIfExists('cleanse_recruitment_teams');
        Schema::dropIfExists('cleanse_recruitment_players');
    }
}
