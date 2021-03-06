<?php

namespace Tests;

use Database\Seeders\AccountTypeSeeder;
use Database\Seeders\DefaultSettingSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function setUp(): void
	{
		parent::setUp(); // TODO: Change the autogenerated stub
		$this->seed([AccountTypeSeeder::class, DefaultSettingSeeder::class]);
	}
}
