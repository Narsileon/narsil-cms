<?php

namespace Narsil\Cms\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Base\Traits\HasTranslations;
use Narsil\Base\Traits\HasUuidPrimaryKey;
use Narsil\Base\Traits\Orderable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterSocialMedium extends Model
{
    use HasTranslations;
    use HasUuidPrimaryKey;
    use Orderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        $this->translatable = [
            self::LABEL,
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
    final public const TABLE = 'footer_social_media';

    #region • COLUMNS

    /**
     * The name of the "footer id" column.
     *
     * @var string
     */
    final public const FOOTER_ID = 'footer_id';

    /**
     * The name of the "icon" column.
     *
     * @var string
     */
    final public const ICON = 'icon';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

    /**
     * The name of the "url" column.
     *
     * @var string
     */
    final public const URL = 'url';

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
