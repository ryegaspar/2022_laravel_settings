<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\DefaultSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
	use RefreshDatabase;

	protected $managerLists = '[{"name":"joe"},{"name":"gabe"},{"name":"michael"},{"name":"natalie"}]';

	/**
	 * test tc account with default tc settings
	 * @test
	 */
	public function when_an_account_is_created_a_setting_is_also_created_from_settings_default()
	{
		$this->assertDatabaseCount('settings', 0);

		$this->makeTcAccount();

		$this->assertDatabaseCount('settings', 3);
		$this->assertDatabaseHas('settings', [
			'default_setting_id' => 1,
			'account_id'         => 1,
			'value'              => 1
		]);
		$this->assertDatabaseHas('settings', [
			'default_setting_id' => 2,
			'account_id'         => 1,
			'value'              => $this->managerLists
		]);
		$this->assertDatabaseHas('settings', [
			'default_setting_id' => 3,
			'account_id'         => 1,
			'value'              => 'FA'
		]);
	}

	/** @test */
	public function it_can_get_specific_setting_of_an_account()
	{
		$account = $this->makeTcAccount();

		$this->assertEquals(1, $account->settings->value('is_ach_enabled'));
		$this->assertEquals($this->managerLists, $account->settings->value('managers'));
		$this->assertEquals('FA', $account->settings->value('pay_processor'));

		$tcAccountType = AccountType::find(1);
		$newDefaultSetting = DefaultSetting::create([
			'account_type_id' => $tcAccountType->id,
			'name'            => 'title',
			'type'            => 'string',
			'default'         => 'random title',
		]);

		$newAccount = Account::factory()->create([
			'account_type_id' => $tcAccountType->id
		]);

		$this->assertEquals('random title', $newAccount->settings->value('title'));
	}

	/** @test */
	public function it_can_assign_a_setting_for_a_given_account()
	{
		$account = $this->makeTcAccount();

		$this->assertEquals('FA', $account->settings->pay_processor);

		$account->settings->set('pay_processor', 'HL');
		$this->assertEquals('HL', $account->fresh()->settings->pay_processor);

		$newAccount = $this->makeTcAccount();
		$this->assertEquals('FA', $newAccount->settings->pay_processor);

		$vendorAccount = Account::factory()->create([
			'account_type_id' => AccountType::find(2)->id
		]);

		$this->assertEquals('nike', $vendorAccount->settings->brand);

		$vendorAccount->settings->set('brand', 'adidas');
		$this->assertEquals('adidas', $vendorAccount->fresh()->settings->brand);
	}

	protected function makeTcAccount(): Account
	{
		return Account::factory()->create([
				'account_type_id' => AccountType::find(1)->id
			]);
	}
	/*
	 * TODO:
	 *
	 * get methods
	 * $account->settings->value('is_ach_enabled') ** done
	 * $account->settings->is_ach_enabled ** done
	 * $account->settings->only(...)** done
	 * $account->settings->except(...)** done
	 *
	 * set methods
	 * $account->settings->is_ach_enabled = false ** done
	 * $account->settings->set('is_ach_enabled', false) ** done
	 * $account->settings->set(['is_ach_enabled' => false, 'pay_processor' => 'HL']) ** done
	 *
	 * reset to default
	 * $account->settings->get('pay_processor')->setDefault();
	 * $account->settings->setDefault('pay_processor') ** done
	 *
	 * next steps:
	 * re-sync individual settings when default settings changed (added / removed)
	 * implement and enforce setting types
	 * introduce caching, invalidate cache when updated (maybe?, maybe use redis?)
	 */
}
