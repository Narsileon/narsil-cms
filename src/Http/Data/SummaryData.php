<?php

namespace Narsil\Cms\Http\Data;

#region USE

use Illuminate\Support\Fluent;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SummaryData extends Fluent
{
    #region CONSTRUCTOR

    /**
     * @param string $href
     * @param string $name
     *
     * @return void
     */
    public function __construct(
        string $href,
        string $name,
    )
    {
        $this->set('href', $href);
        $this->set('name', $name);
    }

    #endregion
}
