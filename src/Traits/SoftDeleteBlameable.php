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
trait SoftDeleteBlameable
{
    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "deleted by" column.
     *
     * @var string
     */
    final public const DELETED_BY = 'deleted_by';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "remover" relation.
     *
     * @var string
     */
    final public const RELATION_REMOVER = 'remover';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the user who deleted the model.
     *
     * @return BelongsTo
     */
    final public function remover(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::DELETED_BY,
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
    protected static function bootSoftDeleteBlameable(): void
    {
        static::deleting(function (Model $model)
        {
            static::setRemover($model);
        });
    }

    /**
     * Fill the "deleted by" column with the ID of the user who deleted the model.
     *
     * @param Model $model
     *
     * @return void
     */
    final protected static function setRemover(Model $model): void
    {
        if (Auth::check())
        {
            $model->{self::DELETED_BY} = Auth::id();

            $model->saveQuietly();
        }
    }

    #endregion
}
