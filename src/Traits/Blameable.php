<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Model;
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

    #region • COLUMNS

    /**
     * The name of the "created by" column.
     *
     * @var string
     */
    final public const CREATED_BY = 'created_by';

    /**
     * The name of the "updated by" column.
     *
     * @var string
     */
    final public const UPDATED_BY = 'updated_by';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "creator" relation.
     *
     * @var string
     */
    final public const RELATION_CREATOR = 'creator';

    /**
     * The name of the "editor" relation.
     *
     * @var string
     */
    final public const RELATION_EDITOR = 'editor';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function loadMissingCreatorAndEditor(): void
    {
        $this->loadMissing([
            self::RELATION_CREATOR => function ($query)
            {
                $query->select(
                    User::ID,
                    User::FIRST_NAME,
                    User::LAST_NAME,
                );
            },
            self::RELATION_EDITOR => function ($query)
            {
                $query->select(
                    User::ID,
                    User::FIRST_NAME,
                    User::LAST_NAME,
                );
            },
        ]);
    }

    #region • RELATIONSHIPS

    /**
     * Get the user who created the model.
     *
     * @return BelongsTo
     */
    final public function creator(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::CREATED_BY,
                User::ID,
            );
    }

    /**
     * Get the user who updated the model.
     *
     * @return BelongsTo
     */
    final public function editor(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::UPDATED_BY,
                User::ID,
            );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the trait.
     *
     * @return void
     */
    final protected static function bootBlameable(): void
    {
        static::creating(function (Model $model)
        {
            static::setCreator($model);
        });

        static::updating(function (Model $model)
        {
            static::setEditor($model);
        });
    }

    /**
     * Fill the "created by" column with the ID of the user who created the model.
     *
     * @param Model $model
     *
     * @return void
     */
    final protected static function setCreator(Model $model): void
    {
        if (Auth::check())
        {
            $model->{self::CREATED_BY} = Auth::id();
        }
    }

    /**
     * Fill the "updated by" column with the ID of the user who updated the model.
     *
     * @param Model $model
     *
     * @return void
     */
    final protected static function setEditor(Model $model): void
    {
        if (Auth::check())
        {
            $model->{self::UPDATED_BY} = Auth::id();
        }
    }

    #endregion
}
