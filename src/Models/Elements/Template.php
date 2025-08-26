<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Traits\HasDatetimes;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Template extends Model
{
    use HasDatetimes;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_BLOCKS,
            self::RELATION_SECTIONS,
        ], $this->with);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'templates';

    #region • COLUMNS

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #region • COUNTS

    /**
     * The name of the "entities" count.
     *
     * @var string
     */
    final public const COUNT_ENTITIES = 'entities_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "sections" relation.
     *
     * @var string
     */
    final public const RELATION_SECTIONS = 'sections';

    #endregion

    #endregion

    #region RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return BelongsToMany
     */
    public function blocks(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Block::class,
                TemplateBlock::class,
                TemplateBlock::TEMPLATE_ID,
                TemplateBlock::BLOCK_ID,
            );
    }

    /**
     * Get the associated sections.
     *
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this
            ->hasMany(
                TemplateSection::class,
                TemplateSection::TEMPLATE_ID,
                self::ID,
            )
            ->orderBy(TemplateSection::POSITION);
    }

    #endregion
}
