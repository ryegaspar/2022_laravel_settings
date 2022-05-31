<?php

namespace Database\Seeders;

use App\Models\DefaultSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSettingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->createTCDefaultSettings();
		$this->createVendorDefaultSettings();
	}

	protected function createTCDefaultSettings()
	{
		DefaultSetting::factory()
			->count(3)
			->sequence(
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
					'name'            => 'pay_processor',
					'type'            => 'string',
					'default'         => 'FA'
				]
			)
			->create();
	}

	protected function createVendorDefaultSettings()
	{
		DefaultSetting::factory()
			->count(3)
			->sequence(
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
					'name'            => 'navigation_color',
					'type'            => 'string',
					'default'         => 'blue'
				],
				[
					'account_type_id' => 2,
					'name'            => 'number_of_installments',
					'type'            => 'integer',
					'default'         => 2
				],
			)
			->create();
	}
}
