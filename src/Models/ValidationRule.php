<?php

namespace Narsil\Models;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ValidationRule extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->mergeAppends([
            self::ATTRIBUTE_NAME,
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
    final public const TABLE = 'validation_rules';

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

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "name" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_NAME = 'name';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the validation rules as select options.
     *
     * @return array<SelectOption>
     */
    public static function selectOptions(): array
    {
        return self::all()
            ->map(function (ValidationRule $validationRule)
            {
                return new SelectOption()
                    ->optionLabel($validationRule->{self::ATTRIBUTE_NAME})
                    ->optionValue($validationRule->{self::ID});
            })
            ->all();
    }

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * Get the name.
     *
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn() => trans('narsil::validation-rules.' . $this->{self::HANDLE}),
        );
    }

    #endregion
}
