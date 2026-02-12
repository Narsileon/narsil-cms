<?php

namespace Narsil\Cms\Traits;

#region USE

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Narsil\Base\Traits\HasUuidPrimaryKey;
use Narsil\Cms\Traits\HasDatetimes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasRevisions
{
    use HasDatetimes;
    use HasUuidPrimaryKey;
    use Publisheable;
    use SoftDeletes;

    #region CONSTANTS

    /**
     * The revision of the draft.
     *
     * @var integer
     */
    private const DRAFT_REVISION = -1;

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

    #endregion

    #region • COUNTS

    /**
     * The name of the "revisions" count.
     *
     * @var string
     */
    final public const COUNT_REVISIONS = 'revisions_count';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "has draft" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_HAS_DRAFT = 'has_draft';

    /**
     * The name of the "has new revision" relation.
     *
     * @var string
     */
    final public const ATTRIBUTE_HAS_NEW_REVISION = 'has_new_revision';

    /**
     * The name of the "has published revision" relation.
     *
     * @var string
     */
    final public const ATTRIBUTE_HAS_PUBLISHED_REVISION = 'has_published_revision';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "draft" relation.
     *
     * @var string
     */
    final public const RELATION_DRAFT = 'draft';

    /**
     * The name of the "published revision" relation.
     *
     * @var string
     */
    final public const RELATION_PUBLISHED_REVISION = 'published_revision';

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
        $uuids = static::onlyTrashed()
            ->where(self::ID, $this->{self::ID})
            ->where(self::PUBLISHED, false)
            ->orderByDesc(self::REVISION)
            ->skip($max)
            ->take(PHP_INT_MAX)
            ->pluck(self::UUID)
            ->toArray();

        if (!empty($uuids))
        {
            static::query()
                ->whereIn(self::UUID, $uuids)
                ->forceDelete();
        }
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated draft.
     *
     * @return HasOne
     */
    final public function draft(): HasOne
    {
        return $this
            ->hasOne(
                static::class,
                self::ID,
                self::ID,
            )
            ->where(self::REVISION, self::DRAFT_REVISION);
    }

    /**
     * Get the published revision.
     *
     * @return HasOne
     */
    final public function published_revision(): HasOne
    {
        return $this
            ->hasOne(
                static::class,
                self::ID,
                self::ID,
            )
            ->withTrashed()
            ->orderByDesc(self::REVISION)
            ->where(self::PUBLISHED, true);
    }

    /**
     * Get the associated revisions.
     *
     * @return HasMany
     */
    final public function revisions(): HasMany
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
            self::query()
                ->where(self::ID, $model->{self::ID})
                ->forceDelete();
        });

        static::replicating(function (Model $model)
        {
            $model->{self::REVISION} = $model->{self::REVISION} + 1;
        });
    }

    #region • ATTRIBUTES

    /**
     * Get the "has draft" attribute.
     *
     * @return Attribute
     */
    final protected function hasDraft(): Attribute
    {
        return new Attribute(
            get: function ()
            {
                return $this->draft()->exists();
            },
        );
    }

    /**
     * Get the "has new revision" attribute.
     *
     * @return Attribute
     */
    final protected function hasNewRevision(): Attribute
    {
        return new Attribute(
            get: function ()
            {
                $maxRevision = static::query()
                    ->where(self::ID, $this->{self::ID})
                    ->orderByDesc(self::REVISION)
                    ->first();

                if ($maxRevision && $maxRevision->{self::PUBLISHED})
                {
                    return false;
                };

                return true;
            },
        );
    }

    /**
     * Get the "has published revision" attribute.
     *
     * @return Attribute
     */
    final protected function hasPublishedRevision(): Attribute
    {
        return new Attribute(
            get: function ()
            {
                return $this->published_revision()->exists();
            },
        );
    }

    #endregion

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
