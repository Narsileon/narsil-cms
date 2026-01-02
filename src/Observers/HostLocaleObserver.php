<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Hosts\HostLocale;

#endregion


/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostLocaleObserver
{
    #region PUBLIC METHODS

    /**
     * @param HostLocale $model
     *
     * @return void
     */
    public function saving(HostLocale $model): void
    {
        $model->{HostLocale::REGEX} = $this->generateRegex($model);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param HostLocale $model
     *
     * @return string
     */
    protected function generateRegex(HostLocale $model): string
    {
        $regex = preg_quote($model->{HostLocale::PATTERN}, '#');

        $regex = strtr($regex, [
            '\{host\}' => '(?P<host>[^/]+)',
            '\{language\}' => '(?P<language>[a-z]{2})',
            '\{country\}' => '(?P<country>[A-Za-z]{2})',
        ]);

        return '#^' . $regex . '(?:/(?P<path>.*))?$#i';
    }

    #endregion
}
