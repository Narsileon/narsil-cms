<?php

namespace App\Http\Requests\Sessions;

#region USE

use App\Enums\SessionEnum;
use App\Http\Requests\AbstractFormRequest;
use Illuminate\Validation\Rule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionDeleteRequest extends AbstractFormRequest
{
    #region CONSTANTS

    /**
     * @var string The name of the "type" parameter.
     */
    public const TYPE = 'type';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            self::TYPE => [
                self::STRING,
                Rule::enum(SessionEnum::class),
            ],
        ];
    }

    #endregion
}
