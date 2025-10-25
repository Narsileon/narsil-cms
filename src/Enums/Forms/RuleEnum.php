<?php

namespace Narsil\Enums\Forms;

#region USE

use Illuminate\Support\Facades\Cache;
use Narsil\Support\SelectOption;
use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum RuleEnum: string
{
    use Enumerable;

    case REQUIRED = 'required';
    case ALPHA_DASH = 'alpha_dash';
    case ARRAY = 'array';
    case BOOLEAN = 'boolean';
    case CONFIRMED = 'confirmed';
    case DATE = 'date';
    case DECIMAL = 'decimal';
    case DISTINCT = 'distinct';
    case EMAIL = 'email';
    case IMAGE = 'image';
    case INTEGER = 'integer';
    case LOWERCASE = 'lowercase';
    case NULLABLE = 'nullable';
    case NUMERIC = 'numeric';
    case SOMETIMES = 'sometimes';
    case STRING = 'string';
    case URL = 'url';
    case UUID = 'uuid';

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function options(): array
    {
        return Cache::rememberForever(static::class . ':options', function ()
        {
            $options = [];

            foreach (self::cases() as $case)
            {
                $options[] = new SelectOption(
                    label: trans("narsil::rules.$case->value"),
                    value: $case->value
                );
            }

            return $options;
        });
    }

    #endregion
}
