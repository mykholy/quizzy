<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsActiveScope
{
    public static function bootIsActiveScope()
    {
        static::addGlobalScope('is_active', function (Builder $builder) {
            if (request()->is('api/*')) {

                $builder->where('is_active', true);
            }
        });
    }
}
