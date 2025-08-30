<?php

namespace Narsil\Enums\Forms;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum RuleEnum: string
{
    use Enumerable;

    case REQUIRED = 'required';
    case ARRAY = 'array';
    case BOOLEAN = 'boolean';
    case CONFIRMED = 'confirmed';
    case DATE = 'date';
    case DECIMAL = 'decimal';
    case DISTINCT = 'distinct';
    case EMAIL = 'email';
    case IMAGE = 'image';
    case INTEGER = 'integer';
    case NULLABLE = 'nullable';
    case NUMERIC = 'numeric';
    case SOMETIMES = 'sometimes';
    case STRING = 'string';
    case URL = 'url';
    case UUID = 'uuid';
}
