<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	use HasFactory;

	protected static function boot()
	{
		parent::boot();

		static::created(function ($model) {
			$model->accountType
				->defaultSettings
				->each(fn($defaultSetting) => $model->settings()
					->create([
						'default_setting_id' => $defaultSetting->id,
						'account_id'         => $model->id,
						'value'              => $defaultSetting->default
					])
				);
		});
	}

	public function accountType()
	{
		return $this->belongsTo(AccountType::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function settings()
	{
		return $this->hasMany(Setting::class);
	}
}
