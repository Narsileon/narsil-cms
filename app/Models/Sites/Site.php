<?php

namespace App\Models\Sites;

#region USE

use App\Contracts\Enable;
use App\Models\Sites\SiteGroup;
use App\Traits\HasFormattedDatetime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Site extends Model implements Enable
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

        $this->casts = array_merge([
            self::PRIMARY => 'boolean',
        ], $this->casts);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_GROUP,
        ], $this->with);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "group id" column.
     */
    final public const GROUP_ID = 'group_id';
    /**
     * @var string The name of the "handle" column.
     */
    final public const HANDLE = 'handle';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "language" column.
     */
    final public const LANGUAGE = 'language';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';
    /**
     * @var string The name of the "primary" column.
     */
    final public const PRIMARY = 'primary';

    /**
     * @var string The name of the "group" relation.
     */
    final public const RELATION_GROUP = 'group';

    /**
     * @var string The name of the "sites" table.
     */
    final public const TABLE = 'sites';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(
            SiteGroup::class,
            self::GROUP_ID,
            SiteGroup::ID
        );
    }

    #endregion
}
