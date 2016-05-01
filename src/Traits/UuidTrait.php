<?php

namespace IanOlson\Support\Traits;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    /**
     * Boot the Uuid trait for the model.
     */
    protected static function boot()
    {
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
