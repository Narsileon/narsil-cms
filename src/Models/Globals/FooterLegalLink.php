<?php

namespace Narsil\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterLegalLink extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasTranslations;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->translatable = [
            self::LABEL,
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
    final public const TABLE = 'footer_legal_links';

    #region • COLUMNS

    /**
     * The name of the "footer id" column.
     *
     * @var string
     */
    final public const FOOTER_ID = 'footer_id';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

    /**
     * The name of the "page id" column.
     *
     * @var string
     */
    final public const PAGE_ID = 'page_id';

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
     * The name of the "footer" relation.
     *
     * @var string
     */
    final public const RELATION_FOOTER = 'footer';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated footer.
     *
     * @return BelongsTo
     */
    final public function footer(): BelongsTo
    {
        return $this
            ->belongsTo(
                Footer::class,
                self::FOOTER_ID,
                Footer::ID,
            );
    }

    #endregion

    #endregion
}
