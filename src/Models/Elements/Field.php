<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Narsil\Casts\JsonCast;
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
class Field extends Model
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
            self::DESCRIPTION,
            self::NAME,
        ];

        $this->with = [
            self::RELATION_BLOCKS,
            self::RELATION_OPTIONS,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);
        $this->mergeCasts([
            self::SETTINGS => JsonCast::class,
            self::TRANSLATABLE => 'boolean',
        ]);

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);

        if ($blocks = Arr::get($attributes, self::RELATION_BLOCKS))
        {
            $this->setRelation(self::RELATION_BLOCKS, collect($blocks));
        }

        if ($options = Arr::get($attributes, self::RELATION_OPTIONS))
        {
            $this->setRelation(self::RELATION_OPTIONS, collect($options));
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
     * The name of the "class name" column.
     *
     * @var string
     */
    final public const CLASS_NAME = 'class_name';

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
     * The name of the "rules" column.
     *
     * @var string
     */
    final public const RULES = 'rules';

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

    /**
     * The name of the "rules" relation.
     *
     * @var string
     */
    final public const RELATION_RULES = 'rules';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • ACCESSORS

    /**
     * Get the icon of the field.
     *
     * @return string|null
     */
    public function getIconAttribute(): ?string
    {
        if ($type = $this->{self::TYPE})
        {
            $class = app($type);

            return $class::getIcon();
        }

        return null;
    }

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return BelongsToMany
     */
    final public function blocks(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Block::class,
                FieldBlock::class,
                FieldBlock::FIELD_ID,
                FieldBlock::BLOCK_ID,
            );
    }

    /**
     * Get the associated options.
     *
     * @return HasMany
     */
    final public function options(): HasMany
    {
        return $this
            ->hasMany(
                FieldOption::class,
                FieldOption::FIELD_ID,
                self::ID,
            )
            ->orderby(FieldOption::POSITION);
    }

    /**
     * Get the associated rules.
     *
     * @return HasMany
     */
    final public function rules(): HasMany
    {
        return $this
            ->hasMany(
                FieldRule::class,
                FieldRule::FIELD_ID,
                self::ID,
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
