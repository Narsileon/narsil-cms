<?php

namespace Narsil\Cms\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Base\Traits\AuditLoggable;
use Narsil\Base\Traits\Blameable;
use Narsil\Cms\Database\Factories\FooterFactory;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Traits\HasDatetimes;
use Narsil\Cms\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[UseFactory(FooterFactory::class)]
class Footer extends Model
{
    use Blameable;
    use AuditLoggable;
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

        $this->translatable = [
            self::CITY,
            self::COPYRIGHT,
            self::EMAIL,
        ];

        $this->with = [
            self::RELATION_LINKS,
            self::RELATION_SOCIAL_MEDIA,
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
    final public const TABLE = 'footers';

    #region • COLUMNS

    /**
     * The name of the "city" column.
     *
     * @var string
     */
    final public const CITY = 'city';

    /**
     * The name of the "copyright" column.
     *
     * @var string
     */
    final public const COPYRIGHT = 'copyright';

    /**
     * The name of the "country" column.
     *
     * @var string
     */
    final public const COUNTRY = 'country';

    /**
     * The name of the "email" column.
     *
     * @var string
     */
    final public const EMAIL = 'email';

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
     * The name of the "organization" column.
     *
     * @var string
     */
    final public const ORGANIZATION = 'organization';

    /**
     * The name of the "organization schema" column.
     *
     * @var string
     */
    final public const ORGANIZATION_SCHEMA = 'organization_schema';

    /**
     * The name of the "phone" column.
     *
     * @var string
     */
    final public const PHONE = 'phone';

    /**
     * The name of the "postal code" column.
     *
     * @var string
     */
    final public const POSTAL_CODE = 'postal_code';

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    /**
     * The name of the "street" column.
     *
     * @var string
     */
    final public const STREET = 'street';

    #endregion

    #region • COUNTS

    /**
     * The name of the "links" count.
     *
     * @var string
     */
    final public const COUNT_LINKS = 'links_count';

    /**
     * The name of the "social media" count.
     *
     * @var string
     */
    final public const COUNT_SOCIAL_MEDIA = 'social_media_count';

    /**
     * The name of the "websites" count.
     *
     * @var string
     */
    final public const COUNT_WEBSITES = 'websites_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "links" relation.
     *
     * @var string
     */
    final public const RELATION_LINKS = 'links';

    /**
     * The name of the "social media" relation.
     *
     * @var string
     */
    final public const RELATION_SOCIAL_MEDIA = 'social_media';

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
     * Get the associated links.
     *
     * @return HasMany
     */
    final public function links(): HasMany
    {
        return $this
            ->hasMany(
                FooterLink::class,
                FooterLink::FOOTER_ID,
                self::ID
            )
            ->orderBy(FooterLink::POSITION);
    }

    /**
     * Get the associated social media.
     *
     * @return HasMany
     */
    final public function social_media(): HasMany
    {
        return $this
            ->hasMany(
                FooterSocialMedium::class,
                FooterSocialMedium::FOOTER_ID,
                self::ID,
            )
            ->orderBy(FooterSocialMedium::POSITION);
    }

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
                Site::FOOTER_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
