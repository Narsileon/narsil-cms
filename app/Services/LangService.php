<?php

namespace App\Services;

#region USE

use App\Models\User;
use App\Models\UserConfiguration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class LangService
{
    #region PUBLIC METHODS

    /**
     * @return string
     */
    public static function getLocale(): string
    {
        $locale = Session::get('locale');

        if (!$locale)
        {
            $locale = Auth::user()?->{User::RELATION_CONFIGURATION}?->{UserConfiguration::LOCALE};
        }

        if (!$locale)
        {
            $locale = App::getLocale();
        }

        return $locale;
    }

    #endregion
}
