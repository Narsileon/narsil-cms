<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Base\Casts\JsonCast;
use Narsil\Cms\Models\ValidationRule;
use Narsil\Cms\Services\Models\FieldService;
use Narsil\Cms\Traits\HasValidationRules;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Field extends BaseElement
{
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
            self::LABEL,
            self::PLACEHOLDER,
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
            self::SETTINGS => JsonCast::class,
        ]);

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
    final public const TABLE = 'fields';

    #region • COLUMNS

    /**
     * The name of the "class name" column.
     *
     * @var string
     */
    final public const CLASS_NAME = 'class_name';

    /**
     * The name of the "placeholder" column.
     *
     * @var string
     */
    final public const PLACEHOLDER = 'placeholder';

    /**
     * The name of the "settings" column.
     *
     * @var string
     */
    final public const SETTINGS = 'settings';

    /**
     * The name of the "type" column.
     *
     * @var string
     */
    final public const TYPE = 'type';

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

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * Get the "icon" attribute.
     *
     * @return string
     */
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                if ($type = $this->{self::TYPE})
                {
                    return FieldService::getIcon($type);
                }

                return null;
            },
        );
    }

    #endregion

    #endregion
}
