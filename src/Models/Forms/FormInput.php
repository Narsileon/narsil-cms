<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Casts\JsonCast;
use Narsil\Services\Models\FieldService;
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
class FormInput extends Model
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
            self::RELATION_OPTIONS,
            self::RELATION_RULES,
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
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'form_inputs';

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
     * The name of the "required" column.
     *
     * @var string
     */
    final public const REQUIRED = 'required';

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

    /**
     * The name of the "rules" count.
     *
     * @var string
     */
    final public const COUNT_RULES = 'rules_count';

    #endregion

    #region • RELATIONS

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
     * Get the icon of the input.
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
     * Get the associated options.
     *
     * @return HasMany
     */
    final public function options(): HasMany
    {
        return $this
            ->hasMany(
                FormInputOption::class,
                FormInputOption::INPUT_ID,
                self::ID,
            )
            ->orderby(FormInputOption::POSITION);
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
                FormInputRule::class,
                FormInputRule::INPUT_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
