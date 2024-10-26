<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateGradesTable extends Migration {

	public function up()
	{
		Schema::create('Grades', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name',255);
			$table->longText('Nodes');
		});
	}

	public function down()
	{
		Schema::drop('Grades');
	}
}