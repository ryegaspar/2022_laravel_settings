<?php

namespace App;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Enumerable;
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

	public function only($keys): Collection|SettingsCollection|static
	{
		if (is_null($keys)) {
			return new static($this->items);
		}

		$keys = is_array($keys) ? $keys : func_get_args();

		return new static(Arr::only($this->items, Arr::wrap($keys)));
	}

	public function except($keys): static
	{
		if ($keys instanceof Enumerable) {
			$keys = $keys->all();
		} elseif (! is_array($keys)) {
			$keys = func_get_args();
		}

		return new static(Arr::except($this->items, $keys));
	}

	public function set(string $name, mixed $value): void
	{
		if ($this->get($name) instanceof Setting) {
			$this->get($name)->update([
				'value' => $value
			]);
		}
	}

	public function __set(string $name, mixed $value): void
	{
		$this->set($name, $value);
	}

	public function __get($key)
	{
		if ($setting = $this->get($key)) {
			return $setting->getAttribute('value');
		}

		return $this->__dynamicGet($key);
	}
}