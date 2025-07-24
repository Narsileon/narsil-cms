<?php

namespace Narsil\Enums\Fields;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum TypeEnum: string
{
    case CHECKBOX = 'checkbox';
    case COMBOBOX = 'combobox';
    case DATE     = 'date';
    case EMAIL    = 'email';
    case NUMBER   = 'number';
    case PASSWORD = 'password';
    case RANGE    = 'range';
    case SELECT   = 'select';
    case SWITCH   = 'switch';
    case TEXT     = 'text';
    case TIME     = 'time';
}
