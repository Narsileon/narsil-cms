<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Caches\Cache;
use Narsil\Support\SelectOption;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Form extends Model
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

        $this->mergeGuarded([
            self::ID,
        ]);

        $this->translatable = [
            self::DESCRIPTION,
            self::TITLE,
        ];

        $this->with = [
            self::RELATION_PAGES,
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
    final public const TABLE = 'forms';

    #region • COLUMNS

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    final public const DESCRIPTION = 'description';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    /**
     * The name of the "title" column.
     *
     * @var string
     */
    final public const TITLE = 'title';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "pages" relation.
     *
     * @var string
     */
    final public const RELATION_PAGES = 'pages';

    /**
     * The name of the "pages" relation.
     *
     * @var string
     */
    final public const RELATION_SUBMISSIONS = 'submissions';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the forms as select options.
     *
     * @return array<SelectOption>
     */
    public static function selectOptions(): array
    {
        return Cache::tags([self::TABLE])
            ->rememberForever('select_options', function ()
            {
                return self::all()
                    ->map(function (Form $form)
                    {
                        return (new SelectOption())
                            ->optionLabel($form->{self::SLUG})
                            ->optionValue($form->{self::ID});
                    })
                    ->all();
            });
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated pages.
     *
     * @return HasMany
     */
    final public function pages(): HasMany
    {
        return $this
            ->hasMany(
                FormTab::class,
                FormTab::FORM_ID,
                self::ID,
            )
            ->orderBy(FormTab::POSITION);
    }

    /**
     * Get the associated submissions.
     *
     * @return HasMany
     */
    final public function submissions(): HasMany
    {
        return $this
            ->hasMany(
                FormSubmission::class,
                FormSubmission::FORM_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
