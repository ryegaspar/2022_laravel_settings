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
		Schema::create('settings_defaults', function (Blueprint $table) {
			$table->id();
			$table->foreignId('account_type_id');
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

		$this->createTCSettingsDefaults();
		$this->createVendorSettingsDefaults();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('settings_defaults');
	}

	protected function createTCSettingsDefaults()
	{
		DB::table('settings_defaults')
			->insert([
				[
					'account_type_id' => 1,
					'name'            => 'is_ach_enabled',
					'type'            => 'boolean',
					'default'         => 1,
				],
				[
					'account_type_id' => 1,
					'name'            => 'managers',
					'type'            => 'collection',
					'default'         => '[{"name":"joe"},{"name":"gabe"},{"name":"michael"},{"name":"natalie"}]'
				],
				[
					'account_type_id' => 1,
					'name' => 'pay_processor',
					'type' => 'string',
					'default' => 'FA'
				]
			]);
	}

	protected function createVendorSettingsDefaults()
	{
		DB::table('settings_defaults')
			->insert([
				[
					'account_type_id' => 2,
					'name'            => 'brand',
					'type'            => 'string',
					'default'         => 'nike',
				],
				[
					'account_type_id' => 2,
					'name'            => 'payment_method',
					'type'            => 'string',
					'default'         => 'ach'
				],
				[
					'account_type_id' => 2,
					'name' => 'navigation_color',
					'type' => 'string',
					'default' => 'blue'
				],
				[
					'account_type_id' => 2,
					'name' => 'number_of_installments',
					'type' => 'integer',
					'default' => 2
				],
			]);
	}
};
