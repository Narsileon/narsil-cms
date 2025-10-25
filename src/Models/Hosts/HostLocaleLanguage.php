<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Traits\HasAuditLogs;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostLocaleLanguage extends Model
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
    final public const TABLE = 'host_locale_languages';

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

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

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
     * Get unique languages.
     *
     * @return array<string>
     */
    public static function getUniqueLanguages(): array
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
     * Get the associated locale.
     *
     * @return BelongsTo
     */
    public function locale(): BelongsTo
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
}
