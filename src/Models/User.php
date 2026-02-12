<?php

namespace Narsil\Cms\Models;

#region USE

use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Base\Models\User as BaseUser;
use Narsil\Cms\Casts\ImageCast;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Traits\HasDatetimes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class User extends BaseUser
{
    use HasDatetimes;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->mergeAppends([
            self::ATTRIBUTE_FULL_NAME,
        ]);

        $this->mergeCasts([
            self::AVATAR => ImageCast::class . ':avatars',
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::ENABLED => 'boolean',
            self::PASSWORD => 'hashed',
        ]);

        $this->mergeGuarded([
            self::EMAIL_VERIFIED_AT,
            self::ID,
            self::PASSWORD,
            self::REMEMBER_TOKEN,
            self::TWO_FACTOR_CONFIRMED_AT,
            self::TWO_FACTOR_RECOVERY_CODES,
            self::TWO_FACTOR_SECRET,
        ]);

        $this->mergeHidden([
            self::PASSWORD,
            self::REMEMBER_TOKEN,
            self::TWO_FACTOR_RECOVERY_CODES,
            self::TWO_FACTOR_SECRET,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    #region • RELATIONS

    /**
     * The name of the "configuration" relation.
     *
     * @var string
     */
    final public const RELATION_BOOKMARKS = 'bookmarks';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated bookmarks.
     *
     * @return HasMany
     */
    final public function bookmarks(): HasMany
    {
        return $this
            ->hasMany(
                UserBookmark::class,
                UserBookmark::USER_ID,
                self::ID
            );
    }

    #endregion

    #endregion
}
