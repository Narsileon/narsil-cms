<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\BlockElement;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasIdentifier;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Block extends Model
{
    use HasDatetimes;
    use HasIdentifier;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->appends = array_merge([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ], $this->appends);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_ELEMENTS,
            self::RELATION_SETS,
        ], $this->with);


        parent::__construct($attributes);

        if ($elements = Arr::get($attributes, self::RELATION_ELEMENTS))
        {
            $this->setRelation(self::RELATION_ELEMENTS, collect($elements));
        }

        if ($sets = Arr::get($attributes, self::RELATION_SETS))
        {
            $this->setRelation(self::RELATION_SETS, collect($sets));
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

    /**
     * The name of the "sets" relation.
     *
     * @var string
     */
    final public const RELATION_SETS = 'sets';

    #endregion

    #endregion

    #region ACCESSORS

    /**
     * Get the icon of the block.
     *
     * @return string
     */
    public function getIconAttribute(): string
    {
        return count($this->{self::RELATION_SETS}) === 0 ? 'box' : 'builder';
    }

    #endregion

    #region RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return MorphToMany
     */
    public function blocks(): MorphToMany
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
    public function elements(): HasMany
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
    public function fields(): MorphToMany
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

    /**
     * Get the associated sets.
     *
     * @return BelongsToMany
     */
    public function sets(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Block::class,
                BlockSet::TABLE,
                BlockSet::BLOCK_ID,
                BlockSet::SET_ID,
            );
    }

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
