<?php

namespace App;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingsCollection extends Collection
{
	public function value($key, $default = null)
	{
		$setting = $this->get($key, $default);

		if ($setting instanceof Setting) {
			return $setting->value;
		}

		return $setting;
	}
}