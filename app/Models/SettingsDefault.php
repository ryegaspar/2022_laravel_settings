<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsDefault extends Model
{
    use HasFactory;

	public function AccountType()
	{
		return $this->belongsTo(AccountType::class);
	}
}
