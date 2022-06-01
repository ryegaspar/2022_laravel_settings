<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Query\Builder as QueryBuilder;

class DefaultSettingScope implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		$builder->beforeQuery(function (QueryBuilder $builder) {
			$builder->join(
				'default_settings',
				'settings.default_setting_id',
				'default_settings.id'
			)
				->select('default_settings.name',
					'default_settings.type',
					'default_settings.default',
					'settings.value',
					'settings.id'
				);
		});
	}
}