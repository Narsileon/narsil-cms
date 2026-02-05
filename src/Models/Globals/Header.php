<?php

namespace Narsil\Cms\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Cms\Database\Factories\HeaderFactory;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Traits\Blameable;
use Narsil\Cms\Traits\HasAuditLogs;
use Narsil\Cms\Traits\HasDatetimes;
use Narsil\Cms\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[UseFactory(HeaderFactory::class)]
class Header extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasFactory;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->mergeGuarded([
            self::ID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'headers';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "logo" column.
     *
     * @var string
     */
    final public const LOGO = 'logo';

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    #endregion

    #region • COUNTS

    /**
     * The name of the "websites" count.
     *
     * @var string
     */
    final public const COUNT_WEBSITES = 'websites_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "websites" relation.
     *
     * @var string
     */
    final public const RELATION_WEBSITES = 'websites';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated websites.
     *
     * @return HasMany
     */
    final public function websites(): HasMany
    {
        return $this
            ->hasMany(
                Site::class,
                Site::HEADER_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
