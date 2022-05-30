<?php

namespace Tests\Unit;

use App\Models\AccountType;
use App\Models\SettingsDefault;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsDefaultTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function it_belongs_to_account_type()
    {
		$setting = SettingsDefault::find(1);

		$this->assertInstanceOf(AccountType::class, $setting->accountType);
    }
}
