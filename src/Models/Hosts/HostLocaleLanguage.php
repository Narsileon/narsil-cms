<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Traits\HasAuditLogs;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class HostLocaleLanguage extends Model
{
    use HasAuditLogs;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'host_locale_languages';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "locale id" column.
     *
     * @var string
     */
    final public const LOCALE_ID = 'locale_id';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

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

    #region • RELATIONSHIPS

    /**
     * Get the associated locale.
     *
     * @return BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this
            ->belongsTo(
                HostLocale::class,
                self::LOCALE_ID,
                HostLocale::ID
            );
    }

    #endregion

    #endregion
}
