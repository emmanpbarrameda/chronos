<?php

namespace Ianstudios\Chronos\Concerns;

use Ianstudios\Chronos\Models\ChronosAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait HasChronos
{
    public static function bootHasChronos()
    {
        static::created(function (Model $model) {
            static::recordAudit('created', $model, [], $model->getAttributes());
        });

        static::updated(function (Model $model) {
            if (empty($model->getDirty())) return;
            
            $old = [];
            $new = [];

            foreach ($model->getDirty() as $key => $value) {
                if (in_array($key, $model->getChronosIgnoredAttributes())) continue;

                $old[$key] = $model->getOriginal($key);
                $new[$key] = $value;
            }

            if (!empty($new)) {
                static::recordAudit('updated', $model, $old, $new);
            }
        });

        static::deleted(function (Model $model) {
            static::recordAudit('deleted', $model, $model->getAttributes(), []);
        });
    }

    protected static function recordAudit($event, Model $model, $old, $new)
    {
        ChronosAudit::create([
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->getKey(),
            'event'          => $event,
            'old_values'     => $old,
            'new_values'     => $new,
            'url'            => Request::fullUrl(),
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'user_id'        => Auth::id(),
        ]);
    }

    public function audits()
    {
        return $this->morphMany(ChronosAudit::class, 'auditable')->latest();
    }

    public function getChronosIgnoredAttributes(): array
    {
        return [
            'updated_at',
            'created_at',
            'deleted_at',
            'password',
            'remember_token',
            'two_factor_secret',
            'two_factor_recovery_codes',
        ];
    }
}