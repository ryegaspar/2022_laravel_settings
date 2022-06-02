<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    use HasFactory;

	protected $guarded = [];

	public function accountType()
	{
		return $this->belongsTo(AccountType::class);
	}

	public function settings()
	{
		return $this->hasMany(Setting::class);
	}
}
