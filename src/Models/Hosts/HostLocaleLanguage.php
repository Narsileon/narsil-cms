<?php

declare(strict_types=1);

namespace Narsil\Cms\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Locale;
use Narsil\Base\Traits\AuditLoggable;
use Narsil\Base\Traits\HasUuidPrimaryKey;
use Narsil\Base\Traits\Orderable;

#endregion

class HostLocaleLanguage extends Model
{
    use AuditLoggable;
    use HasUuidPrimaryKey;
    use Orderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->mergeAppends([
            self::ATTRIBUTE_DISPLAY_LANGUAGE,
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
    final public const TABLE = 'cms.host_locale_languages';

    #region • COLUMNS

    /**
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "locale uuid" column.
     *
     * @var string
     */
    final public const LOCALE_UUID = 'locale_uuid';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "label" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_DISPLAY_LANGUAGE = 'display_language';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "locale" relation.
     *
     * @var string
     */
    final public const RELATION_LOCALE = 'locale';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * @return string
     */
    final public static function getDefaultLanguage(): string
    {
        $language = self::query()
            ->join(
                HostLocale::TABLE,
                HostLocale::TABLE . '.' . HostLocale::UUID,
                '=',
                self::TABLE . '.' . self::LOCALE_UUID,
            )
            ->where(
                HostLocale::TABLE . '.' . HostLocale::COUNTRY,
                HostLocale::COUNTRY_DEFAULT,
            )
            ->orderBy(HostLocale::TABLE . '.' . HostLocale::HOST_ID)
            ->orderBy(self::TABLE . '.' . self::POSITION)
            ->value(self::TABLE . '.' . self::LANGUAGE);

        if ($language === null)
        {
            $language = 'en';
        }

        return $language;
    }

    /**
     * @return string[]
     */
    final public static function getUniqueLanguages(): array
    {
        return self::query()
            ->select(self::LANGUAGE)
            ->distinct()
            ->orderBy(self::LANGUAGE)
            ->pluck(self::LANGUAGE)
            ->toArray();
    }

    #region • RELATIONSHIPS

    /**
     * @return BelongsTo
     */
    final public function locale(): BelongsTo
    {
        return $this
            ->belongsTo(
                HostLocale::class,
                self::LOCALE_UUID,
                HostLocale::UUID,
            );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * @return string
     */
    protected function displayLanguage(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return Locale::getDisplayLanguage($this->{self::LANGUAGE}, App::getLocale());
            },
        );
    }

    #endregion

    #endregion
}
