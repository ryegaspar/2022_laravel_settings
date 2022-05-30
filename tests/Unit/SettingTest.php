<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * test tc account with default tc settings
	 * @test
	 */
	public function when_an_account_is_created_a_setting_is_also_created_from_settings_default()
	{
		$this->assertDatabaseCount('settings', 0);

		$tcAccountType = AccountType::find(1);

		$defaultSetting = $tcAccountType->defaultSettings;

		Account::factory()->create([
			'account_type_id' => $tcAccountType->id
		]);

		$this->assertDatabaseCount('settings', $defaultSetting->count());
		$this->assertDatabaseHas('settings', [
			'default_setting_id' => 1,
			'account_id' => 1,
			'value' => 1
		]);
		$this->assertDatabaseHas('settings', [
			'default_setting_id' => 2,
			'account_id' => 1,
			'value' => '[{"name":"joe"},{"name":"gabe"},{"name":"michael"},{"name":"natalie"}]'
		]);
		$this->assertDatabaseHas('settings', [
			'default_setting_id' => 3,
			'account_id' => 1,
			'value' => 'FA'
		]);
	}
}
