<?php

namespace Narsil\Models\Elements;

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
class Template extends Model
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
            self::NAME,
        ];

        $this->with = [
            self::RELATION_SECTIONS,
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
    final public const TABLE = 'templates';

    #region • COLUMNS

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
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #region • COUNTS

    /**
     * The name of the "entities" count.
     *
     * @var string
     */
    final public const COUNT_ENTITIES = 'entities_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "sections" relation.
     *
     * @var string
     */
    final public const RELATION_SECTIONS = 'sections';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated sections.
     *
     * @return HasMany
     */
    final public function sections(): HasMany
    {
        return $this
            ->hasMany(
                TemplateSection::class,
                TemplateSection::TEMPLATE_ID,
                self::ID,
            )
            ->orderBy(TemplateSection::POSITION);
    }

    #endregion

    #endregion
}
