<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait Blameable
{
    #region CONSTANTS

    /**
     * @var string The name of the "created by" column.
     */
    final public const CREATED_BY = 'created_by';
    /**
     * @var string The name of the "deleted by" column.
     */
    final public const DELETED_BY = 'deleted_by';
    /**
     * @var string The name of the "updated by" column.
     */
    final public const UPDATED_BY = 'updated_by';

    /**
     * @var string The name of the "creator" relation.
     */
    final public const RELATION_CREATOR = 'creator';
    /**
     * @var string The name of the "deleter" relation.
     */
    final public const RELATION_DELETER = 'deleter';
    /**
     * @var string The name of the "updater" relation.
     */
    final public const RELATION_UPDATER = 'updater';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public static function bootBlameable(): void
    {
        static::creating(function ($model)
        {
            if (Auth::check())
            {
                $model->{self::CREATED_BY} = Auth::id();
            }
        });

        static::deleting(function ($model)
        {
            if (Auth::check())
            {
                $model->{self::DELETED_BY} = Auth::id();

                $model->save();
            }
        });

        static::updating(function ($model)
        {
            if (Auth::check())
            {
                $model->{self::UPDATED_BY} = Auth::id();
            }
        });

        static::updated(function ($model)
        {
            if (Auth::check())
            {
                $model->{self::UPDATED_BY} = Auth::id();
            }
        });
    }

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::CREATED_BY,
                User::ID
            );
    }

    /**
     * @return BelongsTo
     */
    public function deleter(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::DELETED_BY,
                User::ID
            );
    }

    /**
     * @return BelongsTo
     */
    public function updater(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::UPDATED_BY,
                User::ID
            );
    }

    #endregion
}
