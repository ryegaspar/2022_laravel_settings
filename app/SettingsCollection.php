<?php

namespace App;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Traits\EnumeratesValues;

class SettingsCollection extends Collection
{
	use EnumeratesValues {
		__get as __dynamicGet;
	}

	public function value($key, $default = null)
	{
		$setting = $this->get($key, $default);

		if ($setting instanceof Setting) {
			return $setting->value;
		}

		return $setting;
	}

	public function __get($key)
	{
		if ($setting = $this->get($key)) {
			return $setting->getAttribute('value');
		}

		return $this->__dynamicGet($key);
	}
}