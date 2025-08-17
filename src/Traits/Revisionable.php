<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait Revisionable
{
    use SoftDeletes;

    #region CONSTANTS

    /**
     * @var string The name of the "deleted at" column.
     */
    final public const DELETED_AT = 'deleted_at';
    /**
     * @var string The name of the "revision" column.
     */
    final public const REVISION = 'revision';

    /**
     * @var string The name of the "revisions" count.
     */
    final public const COUNT_REVISIONS = 'revisions_count';

    /**
     * @var string The name of the "revisions" relation.
     */
    final public const RELATION_REVISIONS = 'revisions';

    #endregion

    #region RELATIONS

    /**
     * Gets the revisions of the model.
     *
     * @return HasMany
     */
    public function revisions(): HasMany
    {
        return $this
            ->hasMany(
                self::class,
                'id',
                'id',
            )
            ->whereNotNull(self::DELETED_AT)
            ->orderByDesc(self::REVISION);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected static function bootRevisionable(): void
    {
        static::creating(function (Model $model)
        {
            if (empty($model->{self::REVISION}))
            {
                $model->{self::REVISION} = 1;
            }
        });

        static::restoring(function (Model $model)
        {
            if ($model->trashed())
            {
                $current = self::query()
                    ->where('id', $model->id)
                    ->whereNull(self::DELETED_AT)
                    ->first();

                if ($current)
                {
                    $current->delete();
                }

                $revision = ($current->{self::REVISION} ?? $model->{self::REVISION} ?? 0) + 1;

                static::createRevision($model, $revision);

                return false;
            }
        });

        static::updating(function (Model $model)
        {
            if ($model->exists)
            {
                $model->delete();

                $revision = ($model->{self::REVISION} ?? 0) + 1;

                static::createRevision($model, $revision);

                return false;
            }
        });
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Model $model
     * @param integer $revision
     *
     * @return false
     */
    private static function createRevision(Model $model, int $revision): void
    {
        $replicated = $model->replicateQuietly();

        $replicated->{Model::CREATED_AT} = $model->{Model::CREATED_AT};
        $replicated->{self::REVISION} = $revision;

        if ($replicated->deleted_at)
        {
            $replicated->deleted_at = null;
        }

        if ($replicated->deleted_by)
        {
            $replicated->deleted_by = null;
        }

        $replicated->saveQuietly();
    }

    #endregion
}
