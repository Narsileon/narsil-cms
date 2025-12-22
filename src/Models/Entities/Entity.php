<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Elements\Template;
use Narsil\Services\CollectionService;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasIdentifier;
use Narsil\Traits\HasRevisions;
use Narsil\Traits\HasTemplate;
use Narsil\Traits\HasTranslations;
use Narsil\Traits\SoftDeleteBlameable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Entity extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasIdentifier;
    use HasRevisions;
    use HasTemplate;
    use HasTranslations;
    use SoftDeleteBlameable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::getTableName();

        $this->primaryKey = self::UUID;

        $this->guarded = [];

        $this->translatable = [
            self::SLUG,
        ];

        $this->with = [
            self::RELATION_BLOCKS,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_TYPE,
        ]);

        if (static::$template)
        {
            $casts = $this->generateCasts(CollectionService::getTemplateFields(static::$template));

            $this->mergeCasts($casts);
        }

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'entities';

    #region • COLUMNS

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "type" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_TYPE = 'type';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "entities" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITIES = 'entities';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getTableName(): string
    {
        return static::$template?->{Template::HANDLE} ?? "";
    }

    /**
     * {@inheritDoc}
     */
    public static function setTemplate(Template|string $template): void
    {
        if (is_string($template))
        {
            $template = Template::query()
                ->firstWhere([
                    Template::HANDLE,
                    $template
                ]);
        }

        static::$template = $template;

        EntityBlock::setTemplate($template);
        EntityBlockField::setTemplate($template);
    }

    #region • ACCESSORS

    /**
     * Get the associated identifier.
     *
     * @return string
     */
    final public function getIdentifierAttribute(): string
    {
        $key = $this->{self::ID};
        $table = $this->getTable();

        return !empty($key) ? "$table-$key" : $table;
    }

    /**
     * Get the associated type.
     *
     * @return string
     */
    final public function getTypeAttribute(): string
    {
        return $this->getTable();
    }

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return HasMany
     */
    final public function blocks(): HasMany
    {
        return $this
            ->hasMany(
                EntityBlock::class,
                EntityBlock::ENTITY_UUID,
                self::UUID,
            )
            ->whereNull(EntityBlock::ENTITY_FIELD_UUID);
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function maxRevisions(): ?int
    {
        return null;
    }

    #endregion
}
