<?php

namespace Tests;

use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function makeTcAccount(): array
	{
		$tcAccountType = AccountType::find(1);

		$defaultSetting = $tcAccountType->defaultSettings;

		return [
			$defaultSetting,
			Account::factory()->create([
				'account_type_id' => $tcAccountType->id
			])
		];
	}
}
