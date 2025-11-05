<?php

namespace Narsil\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Footer extends Model
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
            self::EMAIL,
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
     * The name of the "address line 1" column.
     *
     * @var string
     */
    final public const ADDRESS_LINE_1 = 'address_line_1';

    /**
     * The name of the "address line 2" column.
     *
     * @var string
     */
    final public const ADDRESS_LINE_2 = 'address_line_2';

    /**
     * The name of the "company" column.
     *
     * @var string
     */
    final public const COMPANY = 'company';

    /**
     * The name of the "email" column.
     *
     * @var string
     */
    final public const EMAIL = 'email';

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
     * The name of the "logo" column.
     *
     * @var string
     */
    final public const LOGO = 'logo';

    /**
     * The name of the "phone" column.
     *
     * @var string
     */
    final public const PHONE = 'phone';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "legal links" relation.
     *
     * @var string
     */
    final public const RELATION_LEGAL_LINKS = 'legal_links';

    /**
     * The name of the "social links" relation.
     *
     * @var string
     */
    final public const RELATION_SOCIAL_LINKS = 'social_links';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated legal links.
     *
     * @return HasMany
     */
    final public function legal_links(): HasMany
    {
        return $this
            ->hasOne(
                FooterLegalLink::class,
                FooterLegalLink::FOOTER_ID,
                self::ID,
            )
            ->orderBy(FooterLegalLink::POSITION);
    }

    /**
     * Get the associated social links.
     *
     * @return HasMany
     */
    final public function social_links(): HasMany
    {
        return $this
            ->hasOne(
                FooterSocialLink::class,
                FooterSocialLink::FOOTER_ID,
                self::ID,
            )
            ->orderBy(FooterSocialLink::POSITION);
    }

    #endregion

    #endregion
}
