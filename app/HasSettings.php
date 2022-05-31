<?php

namespace App;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasSettings extends HasMany
{
	public function getResults()
	{
		return new SettingsCollection(
			$this->prepareCollection(parent::getResults())->all()
		);
	}

	protected function prepareCollection(Collection $settings): Collection
	{
		return $settings->keyBy(fn(Setting $setting) => $setting->name);
	}
}