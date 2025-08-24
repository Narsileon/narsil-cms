<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasRevisions
{
    use SoftDeletes;

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    final public const DELETED_AT = 'deleted_at';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "revision" column.
     *
     * @var string
     */
    final public const REVISION = 'revision';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • COUNTS

    /**
     * The name of the "revisions" count.
     *
     * @var string
     */
    final public const COUNT_REVISIONS = 'revisions_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "revisions" relation.
     *
     * @var string
     */
    final public const RELATION_REVISIONS = 'revisions';

    #endregion

    #endregion

    #region RELATIONSHIPS

    /**
     * Get the associated revisions.
     *
     * @return HasMany
     */
    public function revisions(): HasMany
    {
        return $this
            ->hasMany(
                self::class,
                self::ID,
                self::ID,
            )
            ->whereNotNull(self::DELETED_AT)
            ->orderByDesc(self::REVISION);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected static function bootHasRevisions(): void
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
                    ->where(self::ID, $model->{self::ID})
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

    /**
     * Get the maximum number of revisions.
     *
     * @return integer|null
     */
    abstract protected static function maxRevisions(): ?int;

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

        static::pruneRevisions($model->{self::ID});
    }

    /**
     * @param integer $id
     *
     * @return void
     */
    private static function pruneRevisions(int $id): void
    {
        $max = static::maxRevisions();

        if (!$max)
        {
            return;
        }

        $uuids = self::onlyTrashed()
            ->where(self::ID, $id)
            ->orderByDesc(self::REVISION)
            ->skip($max)
            ->take(PHP_INT_MAX)
            ->pluck(self::UUID)
            ->toArray();

        if (!empty($uuids))
        {
            self::query()
                ->whereIn(self::UUID, $uuids)
                ->forceDelete();
        }
    }

    #endregion
}
