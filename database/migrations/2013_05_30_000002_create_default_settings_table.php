<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('default_settings', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_type_id')->constrained();
			$table->string('name');
			$table->enum('type', [
				'array',
				'boolean',
				'collection',
				'datetime',
				'float',
				'integer',
				'string'
			]);
			$table->string('default');
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
		Schema::dropIfExists('default_settings');
	}
};
