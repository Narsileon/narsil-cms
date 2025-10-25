<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasRevisions
{
    use Publishable;
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

    #region PUBLIC METHODS

    /**
     * @param integer $max
     *
     * @return void
     */
    public function pruneRevisions(int $max): void
    {
        $uuids = self::onlyTrashed()
            ->where(self::ID, $this->{self::ID})
            ->where(self::PUBLISHED, false)
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

    #region • RELATIONSHIPS

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
            ->withTrashed()
            ->whereNotNull(self::DELETED_AT)
            ->orderByDesc(self::REVISION);
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootHasRevisions(): void
    {
        static::creating(function (Model $model)
        {
            if (empty($model->{self::ID}))
            {
                $model->{self::ID} = self::max(self::ID) + 1;
            }

            if (empty($model->{self::REVISION}))
            {
                $model->{self::REVISION} = 1;
            }
        });

        static::forceDeleting(function (Model $model)
        {
            self::onlyTrashed()
                ->where(self::ID, $model->{self::ID})
                ->forceDelete();
        });

        static::replicating(function (Model $model)
        {
            $model->{self::REVISION} = $model->{self::REVISION} + 1;
        });
    }

    #region • SCOPES

    /**
     * @param Builder $query
     * @param integer $id
     *
     * @return void
     */
    #[Scope]
    protected function revisionOptions(Builder $query, int $id): void
    {
        $query
            ->withTrashed()
            ->withoutEagerLoads()
            ->select([
                self::ID,
                self::REVISION,
                self::UUID,
            ])
            ->where(self::ID, $id)
            ->orderByDesc(self::REVISION);
    }

    #endregion

    #endregion
}
