<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Site extends Host
{
    #region CONSTANTS

    /**
     * The virtual table associated with the model.
     *
     * @var string
     */
    final public const VIRTUAL_TABLE = 'sites';

    #region • RELATIONS

    /**
     * The name of the "pages" relation.
     *
     * @var string
     */
    final public const RELATION_PAGES = 'pages';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated pages.
     *
     * @return hasMany
     */
    final public function pages(): hasMany
    {
        return $this
            ->hasMany(
                SitePage::class,
                SitePage::SITE_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
