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
class TemplateBlock extends Pivot
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
    final public const TABLE = 'template_blocks';

    #region • COLUMNS

    /**
     * The name of the "block id" column.
     *
     * @var string
     */
    final public const BLOCK_ID = 'block_id';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "template id" column.
     *
     * @var string
     */
    final public const TEMPLATE_ID = 'template_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "block" relation.
     *
     * @var string
     */
    final public const RELATION_BlOCK = 'block';

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
     * Get the associated block.
     *
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this
            ->belongsTo(
                Block::class,
                self::BLOCK_ID,
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
