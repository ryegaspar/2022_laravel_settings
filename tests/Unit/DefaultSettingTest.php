<?php

namespace Tests\Unit;

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
		$setting = DefaultSetting::find(1);

		$this->assertInstanceOf(AccountType::class, $setting->accountType);
    }
}
