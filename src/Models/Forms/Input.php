<?php

namespace Narsil\Cms\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Cms\Casts\JsonCast;
use Narsil\Cms\Models\Collections\BaseElement;
use Narsil\Cms\Models\ValidationRule;
use Narsil\Cms\Services\Models\FieldService;
use Narsil\Cms\Traits\HasValidationRules;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Input extends BaseElement
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
    final public const TABLE = 'inputs';

    #region • COLUMNS

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
     * The name of the "options" count.
     *
     * @var string
     */
    final public const COUNT_OPTIONS = 'options_count';

    #endregion

    #region • RELATIONS

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
     * Get the associated options.
     *
     * @return HasMany
     */
    final public function options(): HasMany
    {
        return $this
            ->hasMany(
                InputOption::class,
                InputOption::INPUT_ID,
                self::ID,
            )
            ->orderby(InputOption::POSITION);
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
                InputValidationRule::class,
                InputValidationRule::INPUT_ID,
                InputValidationRule::VALIDATION_RULE_ID,
            )
            ->using(InputValidationRule::class);
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
