<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function when_an_account_is_created_a_setting_is_also_created_from_settings_default()
    {
		$this->assertDatabaseCount('settings', 0);

		$tcAccountType = AccountType::find(1);
		$account = Account::factory()->create([
			'account_type_id' => $tcAccountType->id
		]);

		$this->assertDatabaseCount('settings', 1);
    }
}
