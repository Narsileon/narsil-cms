<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Session;
use Narsil\Models\TreeModel;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPage extends TreeModel
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
            self::TITLE,
        ];

        $this->with = [
            self::RELATION_OVERRIDES,
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
    final public const TABLE = 'host_pages';

    #region • COLUMNS

    /**
     * The name of the "change freq" column.
     *
     * @var string
     */
    final public const CHANGE_FREQ = 'change_freq';

    /**
     * The name of the "host id" column.
     *
     * @var string
     */
    final public const HOST_ID = 'host_id';

    /**
     * The name of the "host locale uuid" column.
     *
     * @var string
     */
    final public const HOST_LOCALE_UUID = 'host_locale_uuid';

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
     * The name of the "title" column.
     *
     * @var string
     */
    final public const TITLE = 'title';


    #endregion

    #region • RELATIONS

    /**
     * The name of the "host" relation.
     *
     * @var string
     */
    final public const RELATION_HOST = 'host';

    /**
     * The name of the "locale" relation.
     *
     * @var string
     */
    final public const RELATION_LOCALE = 'locale';

    /**
     * The name of the "overrides" relation.
     *
     * @var string
     */
    final public const RELATION_OVERRIDES = 'overrides';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    protected function rebuildTreeRecursively(Collection $collection, array $data, ?TreeModel $parent = null): void
    {
        $country = Session::get(HostLocale::COUNTRY);

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
                if ($country !== 'default' && $left->{self::HOST_LOCALE_UUID} === null)
                {
                    // Overrides
                }
                else
                {
                    $left->update($leftAttributes);
                }
            }

            if ($country !== 'default' && $node->{self::HOST_LOCALE_UUID} === null)
            {
                // Overrides
            }
            else
            {
                $node->update($nodeAttributes);
            }

            if ($children = $dataCollection->get($node->{self::ID})[self::RELATION_CHILDREN] ?? null)
            {
                $this->rebuildTreeRecursively($collection, $children, $node);
            }
        });
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated host.
     *
     * @return BelongsTo
     */
    final public function host(): BelongsTo
    {
        return $this
            ->belongsTo(
                Host::class,
                self::HOST_ID,
                Host::ID
            );
    }

    /**
     * Get the associated locale.
     *
     * @return BelongsTo
     */
    final public function locale(): BelongsTo
    {
        return $this
            ->belongsTo(
                HostLocale::class,
                self::HOST_LOCALE_UUID,
                HostLocale::UUID
            );
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
                HostPageOverride::class,
                HostPageOverride::HOST_PAGE_ID,
                self::ID
            );
    }

    #endregion

    #endregion
}
