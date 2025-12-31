<?php

namespace Narsil\Models\Structures;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Narsil\Casts\JsonCast;
use Narsil\Models\ValidationRule;
use Narsil\Services\Models\FieldService;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasIdentifier;
use Narsil\Traits\HasSecondaryUUID;
use Narsil\Traits\HasTranslations;
use Narsil\Traits\HasValidationRules;

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
    use HasSecondaryUUID;
    use HasTranslations;
    use HasValidationRules;

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
            self::RELATION_VALIDATION_RULES,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeCasts([
            self::REQUIRED => 'boolean',
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
     * The name of the "required" column.
     *
     * @var string
     */
    final public const REQUIRED = 'required';

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
            return FieldService::getIcon($type);
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
            )
            ->using(FieldBlock::class);
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
     * Get the associated validation rules.
     *
     * @return BelongsToMany
     */
    final public function validation_rules(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                ValidationRule::class,
                FieldValidationRule::class,
                FieldValidationRule::FIELD_ID,
                FieldValidationRule::VALIDATION_RULE_ID,
            )
            ->using(FieldValidationRule::class);
    }

    #endregion

    #endregion
}
