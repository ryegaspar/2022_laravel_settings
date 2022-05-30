<?php

namespace Tests\Unit;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * @test
	 */
    public function user_belongs_to_an_account()
    {
		$user = User::factory()->create();

		$this->assertInstanceOf(Account::class, $user->account);
    }
}
