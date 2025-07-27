<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Sites\Site;
use Narsil\Traits\HasFormattedDatetime;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroup extends Model
{
    use HasFormattedDatetime;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';

    /**
     * @var string The name of the "sites" relation.
     */
    final public const RELATION_SITES = 'sites';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'site_groups';

    #endregion

    #region RELATIONS

    /**
     * @return HasMany
     */
    public function sites(): HasMany
    {
        return $this
            ->hasMany(
                Site::class,
                Site::GROUP_ID,
                self::ID
            );
    }

    #endregion
}
