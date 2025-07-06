<?php

namespace App\Enums\Forms;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum TypeEnum: string
{
    case CHECKBOX = 'checkbox';
    case COMBOBOX = 'combobox';
    case EMAIL = 'email';
    case PASSWORD = 'password';
}
