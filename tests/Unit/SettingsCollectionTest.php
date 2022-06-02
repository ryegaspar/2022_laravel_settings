<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Setting;
use App\SettingsCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsCollectionTest extends TestCase
{
	use RefreshDatabase;

	protected SettingsCollection $settingsCollection;
	protected $managerLists = '[{"name":"joe"},{"name":"gabe"},{"name":"michael"},{"name":"natalie"}]';

	protected function setUp(): void
	{
		parent::setUp();

		Account::factory()->create([
			'account_type_id' => AccountType::find(1)->id
		]);

		$this->settingsCollection = new SettingsCollection([
			'is_ach_enabled' => Setting::find(1),
			'managers'       => Setting::find(2),
			'pay_processor'  => Setting::find(3)
		]);
	}

	/** @test */
	public function it_can_get_specific_setting()
	{
		$this->assertEquals(1, $this->settingsCollection->value('is_ach_enabled'));
		$this->assertEquals($this->managerLists, $this->settingsCollection->value('managers'));
		$this->assertEquals('FA', $this->settingsCollection->value('pay_processor'));
	}

	/** @test */
	public function it_can_get_specific_setting_with_magic_get()
	{
		$this->assertEquals(1, $this->settingsCollection->is_ach_enabled);
		$this->assertEquals($this->managerLists, $this->settingsCollection->managers);
		$this->assertEquals('FA', $this->settingsCollection->pay_processor);
	}

	/** @test */
	public function it_can_get_settings_specified_by_only_method()
	{
		$settingsCollection = $this->settingsCollection->only('is_ach_enabled', 'pay_processor');

		$this->assertInstanceOf(SettingsCollection::class, $settingsCollection);

		$this->assertArrayHasKey('is_ach_enabled', $settingsCollection->toArray());
		$this->assertArrayHasKey('pay_processor', $settingsCollection->toArray());
		$this->assertArrayNotHasKey('managers', $settingsCollection->toArray());
		$settingsCollection->each(fn($setting) => $this->assertInstanceOf(Setting::class, $setting));
	}

	/** @test */
	public function it_can_exclude_settings_of_an_account_specified_by_except_method()
	{
		$settingsCollection = $this->settingsCollection->except('managers');

		$this->assertInstanceOf(SettingsCollection::class, $settingsCollection);

		$this->assertArrayHasKey('is_ach_enabled', $settingsCollection->toArray());
		$this->assertArrayHasKey('pay_processor', $settingsCollection->toArray());
		$this->assertArrayNotHasKey('managers', $settingsCollection->toArray());
		$settingsCollection->each(fn($setting) => $this->assertInstanceOf(Setting::class, $setting));

		$otherSettingsCollection = $this->settingsCollection->except('managers', 'pay_processor');
		$this->assertArrayHasKey('is_ach_enabled', $otherSettingsCollection->toArray());
		$this->assertArrayNotHasKey('pay_processor', $otherSettingsCollection->toArray());
		$this->assertArrayNotHasKey('managers', $otherSettingsCollection->toArray());
	}

	/** @test */
	public function it_can_assign_a_setting_for_a_given_account()
	{
		$this->assertEquals('FA', $this->settingsCollection->pay_processor);

		$this->settingsCollection->set('pay_processor', 'HL');
		$this->assertEquals('HL', $this->settingsCollection->get('pay_processor')->value);
	}

	/** @test */
	public function it_can_assign_a_setting_via_set_magic_method()
	{
		$this->assertEquals('FA', $this->settingsCollection->pay_processor);

		$this->settingsCollection->pay_processor = 'HL';
		$this->assertEquals('HL', $this->settingsCollection->get('pay_processor')->value);
	}

	/** @test */
	public function it_can_assign_multiple_values_to_a_setting()
	{
		$this->assertEquals('FA', $this->settingsCollection->pay_processor);
		$this->assertEquals(1, $this->settingsCollection->is_ach_enabled);

		$this->settingsCollection->set([
			'pay_processor' => 'HL',
			'is_ach_enabled' => false
		]);

		$this->assertEquals('HL', $this->settingsCollection->pay_processor);
		$this->assertEquals(0, $this->settingsCollection->is_ach_enabled);
	}

	/** @test */
	public function it_can_reset_the_setting_back_to_its_default_value()
	{
		$this->assertEquals('FA', $this->settingsCollection->pay_processor);

		$this->settingsCollection->pay_processor = 'HL';
		$this->assertEquals('HL', $this->settingsCollection->pay_processor);

		$this->settingsCollection->setDefault('pay_processor');
		$this->assertEquals('FA', $this->settingsCollection->pay_processor);
	}
}
