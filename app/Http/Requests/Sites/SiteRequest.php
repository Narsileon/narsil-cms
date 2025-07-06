<?php

namespace App\Http\Requests\Sites;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            Site::GROUP_ID => [
                self::INTEGER,
                self::NULLABLE,
            ],
            Site::HANDLE => [
                self::STRING,
                self::REQUIRED,
            ],
            Site::LANGUAGE => [
                self::STRING,
                self::REQUIRED,
            ],
            Site::NAME => [
                self::STRING,
                self::REQUIRED,
            ],
            Site::PRIMARY => [
                self::BOOLEAN,
                self::REQUIRED,
            ],
        ];
    }

    #endregion
}
