<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    use HasFactory;

	protected $guarded = [];

	protected static function boot()
	{
		parent::boot();

		static::created(function ($model) {
			$model->accountType
				->accounts
				->each(fn($account) => $account->settings()
					->create([
						'default_setting_id' => $model->id,
						'value' => $model->default
					])
				);
		});
	}

	public function accountType()
	{
		return $this->belongsTo(AccountType::class);
	}

	public function settings()
	{
		return $this->hasMany(Setting::class);
	}
}
