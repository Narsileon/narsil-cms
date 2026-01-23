<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Hosts\Host;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasUuidKey;
use Narsil\Traits\IsOrderable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostLocale extends Model
{
    use HasAuditLogs;
    use HasUuidKey;
    use IsOrderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->with = [
            self::RELATION_LANGUAGES,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'host_locales';

    #region • COLUMNS

    /**
     * The name of the "country" column.
     *
     * @var string
     */
    final public const COUNTRY = 'country';

    /**
     * The name of the "host id" column.
     *
     * @var string
     */
    final public const HOST_ID = 'host_id';

    /**
     * The name of the "pattern" column.
     *
     * @var string
     */
    final public const PATTERN = 'pattern';

    /**
     * The name of the "regex" column.
     *
     * @var string
     */
    final public const REGEX = 'regex';

    #endregion

    #region • COUNTS

    /**
     * The name of the "languages" count.
     *
     * @var string
     */
    final public const COUNT_LANGUAGES = 'languages_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "languages" relation.
     *
     * @var string
     */
    final public const RELATION_LANGUAGES = 'languages';

    /**
     * The name of the "host" relation.
     *
     * @var string
     */
    final public const RELATION_HOST = 'host';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated languages.
     *
     * @return HasMany
     */
    final public function languages(): HasMany
    {
        return $this
            ->hasMany(
                HostLocaleLanguage::class,
                HostLocaleLanguage::LOCALE_UUID,
                self::UUID,
            )
            ->orderBy(HostLocaleLanguage::POSITION);
    }

    /**
     * Get the associated host.
     *
     * @return BelongsTo
     */
    final public function host(): BelongsTo
    {
        return $this
            ->belongsTo(
                Host::class,
                self::HOST_ID,
                Host::ID,
            );
    }

    #endregion

    #endregion
}
