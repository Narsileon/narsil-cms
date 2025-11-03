<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\BlockElement;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasIdentifier;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Block extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasIdentifier;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::NAME,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);

        if ($elements = Arr::get($attributes, self::RELATION_ELEMENTS))
        {
            $this->setRelation(self::RELATION_ELEMENTS, collect($elements));
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'blocks';

    #region • COLUMNS

    /**
     * The name of the "collapsible" column.
     *
     * @var string
     */
    final public const COLLAPSIBLE = 'collapsible';

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

    #region • ATTRIBUTES

    /**
     * The name of the "icon" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_ICON = 'icon';

    #endregion

    #region • COUNTS

    /**
     * The name of the "blocks" count.
     *
     * @var string
     */
    final public const COUNT_BLOCKS = 'blocks_count';

    /**
     * The name of the "elements" count.
     *
     * @var string
     */
    final public const COUNT_ELEMENTS = 'elements_count';

    /**
     * The name of the "fields" count.
     *
     * @var string
     */
    final public const COUNT_FIELDS = 'fields_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "elements" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENTS = 'elements';

    /**
     * The name of the "fields" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDS = 'fields';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • ACCESSORS

    /**
     * Get the icon of the block.
     *
     * @return string
     */
    public function getIconAttribute(): string
    {
        return 'box';
    }

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return MorphToMany
     */
    final public function blocks(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Block::class,
                BlockElement::RELATION_ELEMENT,
                BlockElement::TABLE,
                BlockElement::BLOCK_ID,
                BlockElement::ELEMENT_ID,
            );
    }

    /**
     * Get the associated elements.
     *
     * @return HasMany
     */
    final public function elements(): HasMany
    {
        return $this
            ->hasMany(
                BlockElement::class,
                BlockElement::BLOCK_ID,
                self::ID,
            )
            ->orderBy(BlockElement::POSITION);
    }

    /**
     * Get the associated fields.
     *
     * @return MorphToMany
     */
    final public function fields(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Field::class,
                BlockElement::RELATION_ELEMENT,
                BlockElement::TABLE,
                BlockElement::BLOCK_ID,
                BlockElement::ELEMENT_ID,
            );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function booted(): void
    {
        static::deleting(function ($element)
        {
            $models = [
                BlockElement::class,
                TemplateSectionElement::class,
            ];

            foreach ($models as $model)
            {
                $model::query()
                    ->where('element_type', $element::class)
                    ->where('element_id', $element->getKey())
                    ->delete();
            }
        });
    }

    #endregion
}
