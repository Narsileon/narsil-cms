<?php

namespace Narsil\Cms\Http\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkRequest extends FormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            UserBookmark::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            UserBookmark::URL => [
                FormRule::STRING,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
