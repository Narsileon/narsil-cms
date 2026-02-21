<?php

namespace Narsil\Cms\Models;

#region USE

use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Base\Models\User as BaseUser;
use Narsil\Base\Traits\HasDatetimes;
use Narsil\Cms\Casts\ImageCast;
use Narsil\Cms\Models\Users\UserBookmark;

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

        $this->mergeCasts([
            self::AVATAR => ImageCast::class . ':avatars',
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
