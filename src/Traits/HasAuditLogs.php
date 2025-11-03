<?php

namespace Narsil\Traits;

#region USE

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Narsil\Enums\Database\EventEnum;
use Narsil\Models\AuditLog;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasAuditLogs
{
    #region CONSTANTS

    #region • RELATIONS

    /**
     * The name of the "audit logs" relation.
     *
     * @var string
     */
    final public const RELATION_AUDIT_LOGS = 'audit_logs';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasAuditLogs(): void
    {
        static::getEvents()->each(function ($event)
        {
            static::$event(function (Model $model) use ($event)
            {
                try
                {
                    $newValues = $model->getChanges();
                    $oldValues = self::getOldValues($model, $newValues);

                    if ($model->wasRecentlyCreated)
                    {
                        $newValues = $model->getAttributes();
                    }

                    AuditLog::create([
                        AuditLog::EVENT => $event,
                        AuditLog::MODEL_ID => $model->getKey(),
                        AuditLog::MODEL_TYPE => self::getModelType($model),
                        AuditLog::NEW_VALUES => $newValues,
                        AuditLog::OLD_VALUES => $oldValues,
                        AuditLog::USER_ID => Auth::id(),
                    ]);
                }
                catch (Exception $exception)
                {
                    Log::error($exception->getMessage());
                }
            });
        });
    }

    #region • RELATIONSHIPS

    /**
     * @return MorphMany
     */
    final public function audit_logs(): MorphMany
    {
        return $this->morphMany(
            AuditLog::class,
            AuditLog::RELATION_MODEL,
        );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Collection
     */
    protected static function getEvents(): Collection
    {
        $events = collect([
            EventEnum::CREATED->value,
            EventEnum::DELETED->value,
            EventEnum::UPDATED->value,
        ]);

        if (collect(class_uses_recursive(static::class))->contains(SoftDeletes::class))
        {
            $events->push(EventEnum::RESTORED->value);
        }

        return $events;
    }

    /**
     * @param Model $model
     *
     * @return string
     */
    protected static function getModelType(Model $model): string
    {
        $reflectionClass = new ReflectionClass($model);

        $modelType = $reflectionClass->name;

        return $modelType;
    }

    /**
     * @param Model $model
     * @param array $newValues
     *
     * @return array
     */
    protected static function getOldValues(Model $model, array $newValues): array
    {
        $oldValues = [];

        $keys = array_keys($newValues);

        foreach ($keys as $key)
        {
            $oldValues[$key] = $model->getRawOriginal($key);
        }

        return $oldValues;
    }

    #endregion
}
