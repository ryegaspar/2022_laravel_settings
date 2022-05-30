<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\DefaultSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTypeTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_has_many_accounts()
	{
		$accountType = AccountType::find(1);

		Account::factory()->create(
			[
				'account_type_id' => $accountType->id
			]
		);

		$this->assertInstanceOf(Collection::class, $accountType->accounts);
		$this->assertInstanceOf(Account::class, $accountType->accounts[0]);
	}

	/** @test */
	public function it_has_many_default_settings()
	{
		$accountType = AccountType::find(1);

		$this->assertInstanceOf(Collection::class, $accountType->defaultSettings);
		$this->assertInstanceOf(DefaultSetting::class, $accountType->defaultSettings[0]);
	}
}
