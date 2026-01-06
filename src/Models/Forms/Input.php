<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
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
use Narsil\Traits\HasTranslations;
use Narsil\Traits\HasValidationRules;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Input extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasIdentifier;
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
            self::LABEL,
        ];

        $this->with = [
            self::RELATION_OPTIONS,
            self::RELATION_VALIDATION_RULES,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self
            ::ATTRIBUTE_IDENTIFIER,
        ]);
        $this->mergeCasts([
            self::REQUIRED => 'boolean',
            self::SETTINGS => JsonCast::class,
        ]);

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);

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
    final public const TABLE = 'inputs';

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
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

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
