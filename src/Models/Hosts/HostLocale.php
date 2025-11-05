<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Narsil\Models\Hosts\Host;
use Narsil\Traits\HasAuditLogs;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostLocale extends Model
{
    use HasAuditLogs;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->with = [
            self::RELATION_LANGUAGES,
        ];

        $this->mergeGuarded([
            self::UUID,
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
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "regex" column.
     *
     * @var string
     */
    final public const REGEX = 'regex';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • COUNTS

    /**
     * The name of the "languages" count.
     *
     * @var string
     */
    final public const COUNT_LANGUAGES = 'languages_count';

    #region • ATTRIBUTES

    /**
     * The name of the "urls" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_URLS = 'urls';

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

    /**
     * Get the associated URLs.
     *
     * @return array<string,string>
     */
    public function getUrlsAttribute(): array
    {
        $this->loadMissing([
            self::RELATION_HOST,
            self::RELATION_LANGUAGES,
        ]);

        $pattern = $this->{self::PATTERN};


        $urls = [];

        foreach ($this->{self::RELATION_LANGUAGES} as $hostLocaleLanguage)
        {
            $language = $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE};

            $url = $pattern;

            $url = Str::replace('{host}', $this->{self::RELATION_HOST}->{Host::HANDLE}, $url);
            $url = Str::replace('{country}', $this->{self::COUNTRY}, $url);
            $url = Str::replace('{language}', $language, $url);

            $urls[$language] = Str::lower($url);
        }

        return $urls;
    }

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
