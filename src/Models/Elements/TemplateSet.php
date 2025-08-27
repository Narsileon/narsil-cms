<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Elements\Block;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateSet extends Pivot
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;
        $this->timestamps = false;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'template_set';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "set id" column.
     *
     * @var string
     */
    final public const SET_ID = 'set_id';

    /**
     * The name of the "template id" column.
     *
     * @var string
     */
    final public const TEMPLATE_ID = 'template_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "set" relation.
     *
     * @var string
     */
    final public const RELATION_SET = 'set';

    /**
     * The name of the "template" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE = 'template';

    #endregion

    #endregion

    #region RELATIONSHIPS

    /**
     * Get the associated set.
     *
     * @return BelongsTo
     */
    public function set(): BelongsTo
    {
        return $this
            ->belongsTo(
                Block::class,
                self::SET_ID,
                Block::ID,
            );
    }

    /**
     * Get the associated template.
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this
            ->belongsTo(
                Template::class,
                self::TEMPLATE_ID,
                Template::ID,
            );
    }

    #endregion
}
