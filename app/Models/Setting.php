<?php

namespace App\Models;

use App\DefaultSettingScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

	protected $guarded = [];

	protected static function booted()
	{
		static::addGlobalScope(new DefaultSettingScope);
	}
}
