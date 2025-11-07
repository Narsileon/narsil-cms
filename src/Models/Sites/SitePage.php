<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Session;
use Narsil\Models\TreeModel;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePage extends TreeModel
{
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::META_DESCRIPTION,
            self::OPEN_GRAPH_DESCRIPTION,
            self::OPEN_GRAPH_TITLE,
            self::SLUG,
            self::TITLE,
        ];

        $this->with = [
            self::RELATION_OVERRIDE,
        ];

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'site_pages';

    #region • COLUMNS

    /**
     * The name of the "change freq" column.
     *
     * @var string
     */
    final public const CHANGE_FREQ = 'change_freq';

    /**
     * The name of the "country" column.
     *
     * @var string
     */
    final public const COUNTRY = 'country';

    /**
     * The name of the "meta description" column.
     *
     * @var string
     */
    final public const META_DESCRIPTION = 'meta_description';

    /**
     * The name of the "open graph description" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_DESCRIPTION = 'open_graph_description';

    /**
     * The name of the "open graph image" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_IMAGE = 'open_graph_image';

    /**
     * The name of the "open graph title" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_TITLE = 'open_graph_title';

    /**
     * The name of the "open graph type" column.
     *
     * @var string
     */
    final public const OPEN_GRAPH_TYPE = 'open_graph_type';

    /**
     * The name of the "priority" column.
     *
     * @var string
     */
    final public const PRIORITY = 'priority';

    /**
     * The name of the "robots" column.
     *
     * @var string
     */
    final public const ROBOTS = 'robots';

    /**
     * The name of the "site id" column.
     *
     * @var string
     */
    final public const SITE_ID = 'site_id';

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    /**
     * The name of the "title" column.
     *
     * @var string
     */
    final public const TITLE = 'title';


    #endregion

    #region • RELATIONS

    /**
     * The name of the "override" relation.
     *
     * @var string
     */
    final public const RELATION_OVERRIDE = 'override';

    /**
     * The name of the "overrides" relation.
     *
     * @var string
     */
    final public const RELATION_OVERRIDES = 'overrides';

    /**
     * The name of the "site" relation.
     *
     * @var string
     */
    final public const RELATION_SITE = 'site';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     * @param array $attributes
     *
     * @return void
     */
    public static function syncOverride(SitePage $sitePage, array $attributes): void
    {
        $sitePage->fill($attributes);

        $override = $sitePage->{SitePage::RELATION_OVERRIDE};

        if ($sitePage->isDirty())
        {
            if ($override)
            {
                $override->update($attributes);
            }
            else
            {
                SitePageOverride::create(array_merge($attributes, [
                    SitePageOverride::COUNTRY => Session::get(self::COUNTRY),
                    SitePageOverride::PAGE_ID => $sitePage->{SitePage::ID},
                ]));
            }
        }
        else if ($override)
        {
            $override->delete();
        }
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated override.
     *
     * @return HasOne
     */
    final public function override(): HasOne
    {
        return $this
            ->hasOne(
                SitePageOverride::class,
                SitePageOverride::PAGE_ID,
                self::ID
            )
            ->where(self::COUNTRY, Session::get(self::COUNTRY))
            ->latestOfMany();
    }

    /**
     * Get the associated overrides.
     *
     * @return HasMany
     */
    final public function overrides(): HasMany
    {
        return $this
            ->hasMany(
                SitePageOverride::class,
                SitePageOverride::PAGE_ID,
                self::ID
            );
    }

    /**
     * Get the associated site.
     *
     * @return BelongsTo
     */
    final public function site(): BelongsTo
    {
        return $this
            ->belongsTo(
                Site::class,
                self::SITE_ID,
                Site::ID
            );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function rebuildTreeRecursively(Collection $collection, array $data, ?TreeModel $parent = null): void
    {
        $country = Session::get(SitePage::COUNTRY);

        $ids = collect($data)->pluck(self::ID);

        $nodes = $ids->map(function ($id) use ($collection)
        {
            return $collection->get($id);
        })->filter();

        $dataCollection = collect($data)->keyBy(self::ID);

        $nodes->each(function ($node, $index) use ($collection, $country, $dataCollection, $nodes, $parent)
        {
            $leftAttributes = [];
            $nodeAttributes = [];

            $nodeAttributes[self::PARENT_ID] = $parent?->{self::ID};

            $isLastNode = ($index === $nodes->count() - 1);

            $left = $nodes->get($index - 1);

            if ($left)
            {
                $leftAttributes[self::RIGHT_ID] = $node->{self::ID};
                $nodeAttributes[self::LEFT_ID] = $left->{self::ID};
            }
            else
            {
                $nodeAttributes[self::LEFT_ID] = null;
            }

            if ($isLastNode)
            {
                $nodeAttributes[self::RIGHT_ID] = null;
            }

            if ($left)
            {
                if ($country !== 'default' && $left->{self::COUNTRY} === 'default')
                {
                    static::syncOverride($left, $leftAttributes);
                }
                else
                {
                    $left->update($leftAttributes);
                }
            }

            if ($country !== 'default' && $node->{self::COUNTRY} === 'default')
            {
                static::syncOverride($node, $nodeAttributes);
            }
            else
            {
                $node->update($nodeAttributes);
            }

            if ($children = $dataCollection->get($node->{self::ID})[self::RELATION_CHILDREN] ?? null)
            {
                static::rebuildTreeRecursively($collection, $children, $node);
            }
        });
    }

    #region • ACCESSORS

    /**
     * Get the left id by applying the override if it exists.
     *
     * @return Attribute
     */
    protected function leftId(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->{self::RELATION_OVERRIDE}?->{SitePageOverride::LEFT_ID} ?? $value
        );
    }

    /**
     * Get the parent id by applying the override if it exists.
     *
     * @return Attribute
     */
    protected function parentId(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->{self::RELATION_OVERRIDE}?->{SitePageOverride::PARENT_ID} ?? $value
        );
    }

    /**
     * Get the right id by applying the override if it exists.
     *
     * @return Attribute
     */
    protected function rightId(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->{self::RELATION_OVERRIDE}?->{SitePageOverride::RIGHT_ID} ?? $value
        );
    }

    #endregion

    #endregion
}
