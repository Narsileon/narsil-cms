<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\TreeModel;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated host.
     *
     * @return BelongsTo
     */
    public function host(): BelongsTo
    {
        return $this
            ->belongsTo(
                Host::class,
                self::HOST_ID,
                Host::ID
            );
    }

    #endregion

    #endregion
}
