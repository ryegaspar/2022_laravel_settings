<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\User;
use App\SettingsCollection;
use Illuminate\Database\Eloquent\Collection;
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

	/** @test */
	public function it_has_many_users()
	{
		$account = Account::factory()->create();

		User::factory()->create(
			[
				'account_id' => $account->id
			]
		);

		$this->assertInstanceOf(Collection::class, $account->users);
		$this->assertInstanceOf(User::class, $account->users[0]);
	}

	/** @test */
	public function it_has_many_settings()
	{
		$account = Account::factory()->create([
			'account_type_id' => AccountType::find(1)->id
		]);

		$this->assertInstanceOf(SettingsCollection::class, $account->settings);
		$this->assertEquals(3, $account->settings->count());
	}
}
