<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\DefaultSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultSettingTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function it_belongs_to_account_type()
    {
		$defaultSetting = DefaultSetting::find(1);

		$this->assertInstanceOf(AccountType::class, $defaultSetting->accountType);
    }

	/** @test */
	public function renaming_name_does_not_affect_individual_settings()
	{
		$account = Account::factory()->create([
			'account_type_id' => 2
		]);

		$this->assertEquals('nike', $account->settings->brand);

		// default setting for vendor, brand as the name
		$defaultSetting = DefaultSetting::find(4);
		$defaultSetting->update([
			'name' => 'new_brand_name'
		]);

		$this->assertEquals('nike', $account->fresh()->settings->new_brand_name);
	}
}
