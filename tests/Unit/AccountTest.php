<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_belongs_to_an_account_type()
	{
		$account = Account::factory()->create();

		$this->assertInstanceOf(AccountType::class, $account->accountType);
	}
}
