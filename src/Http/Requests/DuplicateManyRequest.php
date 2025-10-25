<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DuplicateManyRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * @var string
     */
    public const IDS = 'ids';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            self::IDS => [
                FormRule::ARRAY,
            ],
        ];
    }

    #endregion
}
