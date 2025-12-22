<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Forms\FormPage;
use Narsil\Traits\HasElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormPageElement extends Model
{
    use HasElement;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        $this->touches = [
            self::RELATION_PAGE,
        ];

        $this->translatable = [
            self::DESCRIPTION,
            self::NAME,
        ];

        $this->with = [
            self::RELATION_ELEMENT,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

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
    final public const TABLE = 'form_page_element';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "page id" column.
     *
     * @var string
     */
    final public const PAGE_ID = 'page_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "page" relation.
     *
     * @var string
     */
    final public const RELATION_PAGE = 'page';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated page.
     *
     * @return BelongsTo
     */
    final public function page(): BelongsTo
    {
        return $this
            ->belongsTo(
                FormPage::class,
                self::PAGE_ID,
                FormPage::ID,
            );
    }

    #endregion

    #endregion
}
