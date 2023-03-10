<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

trait UuidAsKey
{
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): string
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    public static function booted(): void
    {
        static::creating(function (Model $model) {
            $primaryKey = $model->getKeyName();
            $keyValue =  $model->{$primaryKey};
            if ($keyValue === null) {
                $model->setAttribute($model->getKeyName(), Str::uuid());
            }
        });
    }

    public function getUuid()
    {
        if (is_string($this->uuid)) {
            return Uuid::fromString($this->uuid);
        }

        return $this->uuid;
    }
}
