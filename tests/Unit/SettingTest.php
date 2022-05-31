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

		[$defaultSetting] = $this->makeTcAccount();

		$this->assertDatabaseCount('settings', $defaultSetting->count());
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
		[$defaultSetting, $account] = $this->makeTcAccount();

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
	public function it_can_get_specific_setting_of_an_account_with_magic_get()
	{
		[$defaultSetting, $account] = $this->makeTcAccount();

		$this->assertEquals(1, $account->settings->is_ach_enabled);
		$this->assertEquals($this->managerLists, $account->settings->managers);
		$this->assertEquals('FA', $account->settings->pay_processor);
	}

	/*
	 * TODO:
	 *
	 * get methods
	 * $account->settings->value('is_ach_enabled') ** done
	 * $account->settings->is_ach_enabled ** done
	 * $account->settings->only(...)
	 * $account->settings->except(...)
	 *
	 * set methods
	 * $account->settings->is_ach_enabled = false
	 * $account->settings->set('is_ach_enabled', false)
	 * $account->settings->set(['is_ach_enabled' => false, 'pay_processor' => 'HL'])
	 *
	 * long set method
	 * $ach = $account->settings->is_ach_enabled;
	 * $ach = false
	 * $ach->save()
	 *
	 * reset to default
	 * $account->settings->get('pay_processor')->setDefault();
	 * $account->settings->setDefault('pay_processor')
	 *
	 * next steps:
	 * re-sync individual settings when default settings changed (added / removed)
	 * implement and enforce setting types
	 * introduce caching, invalidate cache when updated (maybe?, maybe use redis?)
	 */
}
