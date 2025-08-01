<?php

namespace Narsil\Enums\Fields;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum AutoCompleteEnum: string
{
    case CURRENT_PASSWORD = 'current-password';
    case EMAIL            = 'email';
    case FAMILY_NAME      = 'family-name';
    case GIVEN_NAME       = 'given-name';
    case NEW_PASSWORD     = 'new-password';
    case ONE_TIME_CODE    = 'one-time-code';
}
