<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\DefaultSetting;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultSettingTest extends TestCase
{
	use RefreshDatabase;

	protected $managerLists = '[{"name":"joe"},{"name":"gabe"},{"name":"michael"},{"name":"natalie"}]';

	/** @test */
	public function it_belongs_to_account_type()
	{
		$defaultSetting = DefaultSetting::find(1);

		$this->assertInstanceOf(AccountType::class, $defaultSetting->accountType);
	}

	/** @test */
	public function it_has_many_settings()
	{
		$account = Account::factory()->create([
			'account_type_id' => 1
		]);

		$defaultSetting = $account->accountType->defaultSettings->first();
		$this->assertInstanceOf(Setting::class, $defaultSetting->settings[0]);
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

	/** @test */
	public function creating_new_default_setting_creates_settings_to_all_accounts_that_belongs_to_the_same_account_type()
	{
		$tcAccountType = AccountType::find(1);

		$account1 = Account::factory()->create([
			'account_type_id' => $tcAccountType->id
		]);
		$account2 = Account::factory()->create([
			'account_type_id' => $tcAccountType->id
		]);
		$account3 = Account::factory()->create([
			'account_type_id' => 2
		]);

		$this->assertEquals(1, $account1->settings->value('is_ach_enabled'));
		$this->assertEquals($this->managerLists, $account1->settings->value('managers'));
		$this->assertEquals('FA', $account1->settings->value('pay_processor'));
		$this->assertEquals(null, $account1->settings->value('store_name'));

		$this->assertEquals(1, $account2->settings->value('is_ach_enabled'));
		$this->assertEquals($this->managerLists, $account2->settings->value('managers'));
		$this->assertEquals('FA', $account2->settings->value('pay_processor'));
		$this->assertEquals(null, $account1->settings->value('store_name'));

		$this->assertEquals(null, $account3->settings->value('store_name'));

		$tcAccountType->defaultSettings()
			->create([
				'name'    => 'store_name',
				'type'    => 'string',
				'default' => 'my awesome store'
			]);

		$this->assertEquals('my awesome store', $account1->fresh()->settings->value('store_name'));
		$this->assertEquals('my awesome store', $account2->fresh()->settings->value('store_name'));
		$this->assertEquals(null, $account3->fresh()->settings->value('store_name'));
	}
}