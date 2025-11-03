<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Host extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::NAME,
        ];

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
    final public const TABLE = 'hosts';

    #region • COLUMNS

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #region • COUNTS

    /**
     * The name of the "locales" count.
     *
     * @var string
     */
    final public const COUNT_LOCALES = 'locales_count';

    #region • RELATIONS

    /**
     * The name of the "default locale" relation.
     *
     * @var string
     */
    final public const RELATION_DEFAULT_LOCALE = 'default_locale';

    /**
     * The name of the "other locales" relation.
     *
     * @var string
     */
    final public const RELATION_OTHER_LOCALES = 'other_locales';

    /**
     * The name of the "locales" relation.
     *
     * @var string
     */
    final public const RELATION_LOCALES = 'locales';

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
     * Get the default associated locale.
     *
     * @return HasOne
     */
    final public function default_locale(): HasOne
    {
        return $this
            ->hasOne(
                HostLocale::class,
                HostLocale::HOST_ID,
                self::ID,
            )
            ->where(HostLocale::COUNTRY, '=', 'default');
    }

    /**
     * Get the other associated locales.
     *
     * @return HasMany
     */
    final public function other_locales(): HasMany
    {
        return $this
            ->hasMany(
                HostLocale::class,
                HostLocale::HOST_ID,
                self::ID,
            )
            ->where(HostLocale::COUNTRY, '!=', 'default')
            ->orderBy(HostLocale::POSITION);
    }

    /**
     * Get the associated locales.
     *
     * @return HasMany
     */
    final public function locales(): HasMany
    {
        return $this
            ->hasMany(
                HostLocale::class,
                HostLocale::HOST_ID,
                self::ID,
            )
            ->orderBy(HostLocale::POSITION);
    }

    /**
     * Get the associated pages.
     *
     * @return hasMany
     */
    final public function pages(): hasMany
    {
        return $this
            ->hasMany(
                HostPage::class,
                HostPage::HOST_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
