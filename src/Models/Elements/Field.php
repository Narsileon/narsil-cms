<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\FieldBlock;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasIdentifier;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Field extends Model
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

        $this->casts = array_merge([
            self::SETTINGS => 'json',
            self::TRANSLATABLE => 'boolean',
        ], $this->casts);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_BLOCKS,
            self::RELATION_OPTIONS,
        ], $this->with);

        parent::__construct($attributes);

        if ($blocks = Arr::get($attributes, self::RELATION_BLOCKS))
        {
            $this->setRelation(self::RELATION_BLOCKS, collect($blocks));
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'fields';

    #region • COLUMNS

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    final public const DESCRIPTION = 'description';

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

    /**
     * The name of the "settings" column.
     *
     * @var string
     */
    final public const SETTINGS = 'settings';

    /**
     * The name of the "translatable" column.
     *
     * @var string
     */
    final public const TRANSLATABLE = 'translatable';

    /**
     * The name of the "type" column.
     *
     * @var string
     */
    final public const TYPE = 'type';

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
     * The name of the "options" count.
     *
     * @var string
     */
    final public const COUNT_OPTIONS = 'options_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "options" relation.
     *
     * @var string
     */
    final public const RELATION_OPTIONS = 'options';

    #endregion

    #endregion

    #region ACCESSORS

    /**
     * Get the icon of the field.
     *
     * @return string|null
     */
    public function getIconAttribute(): ?string
    {
        if ($type = $this->{self::TYPE})
        {
            $class = app()->make($type);

            return $class::getIcon();
        }

        return null;
    }

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
                FieldBlock::TABLE,
                FieldBlock::FIELD_ID,
                FieldBlock::BLOCK_ID,
            );
    }

    /**
     * Get the associated options.
     *
     * @return HasMany
     */
    public function options(): HasMany
    {
        return $this
            ->hasMany(
                FieldOption::class,
                FieldOption::FIELD_ID,
                self::ID,
            )
            ->orderby(FieldOption::POSITION);
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
