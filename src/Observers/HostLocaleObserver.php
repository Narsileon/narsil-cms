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
     * @param HostLocale $hostLocale
     *
     * @return void
     */
    public function saving(HostLocale $hostLocale): void
    {
        $hostLocale->{HostLocale::REGEX} = $this->generateRegex($hostLocale);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param HostLocale $hostLocale
     *
     * @return string
     */
    protected function generateRegex(HostLocale $hostLocale): string
    {
        $regex = preg_quote($hostLocale->{HostLocale::PATTERN}, '#');

        $regex = strtr($regex, [
            '\{host\}' => '(?P<host>[^/]+)',
            '\{language\}' => '(?P<language>[a-z]{2})',
            '\{country\}' => '(?P<country>[A-Za-z]{2})',
        ]);

        return '#^' . $regex . '(?:/(?P<slug>.*))?$#i';
    }

    #endregion
}
