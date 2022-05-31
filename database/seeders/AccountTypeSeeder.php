<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		AccountType::factory()
			->count(2)
			->sequence(
				[
					'type' => 'TC'
				],
				[
					'type' => 'Vendor'
				]
			)
			->create();
	}
}
