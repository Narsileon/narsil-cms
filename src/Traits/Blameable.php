<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

    #region RELATIONSHIPS

    /**
     * Get the user who created the model.
     *
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
     * Get the user who deleted the model.
     *
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
     * Get the user who updated the model.
     *
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

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected static function bootBlameable(): void
    {
        static::creating(function (Model $model)
        {
            if (Auth::check())
            {
                $model->{self::CREATED_BY} = Auth::id();
            }
        });

        static::deleting(function (Model $model)
        {
            if (Auth::check())
            {
                $model->{self::DELETED_BY} = Auth::id();

                $model->saveQuietly();
            }
        });

        static::updating(function (Model $model)
        {
            if (Auth::check())
            {
                $model->{self::UPDATED_BY} = Auth::id();
            }
        });
    }

    #endregion
}
