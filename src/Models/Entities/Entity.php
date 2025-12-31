<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Structures\Template;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasIdentifier;
use Narsil\Traits\HasRevisions;
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
    use HasTranslations;
    use SoftDeleteBlameable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->guarded = [];

        $this->translatable = [
            self::SLUG,
        ];

        $this->with = [
            self::RELATION_FIELDS,
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
    final public const TABLE = 'entities';

    #region • COLUMNS

    /**
     * The name of the "slug" column.
     *
     * @var string
     */
    final public const SLUG = 'slug';

    /**
     * The name of the "template id" column.
     *
     * @var string
     */
    final public const TEMPLATE_ID = 'template_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "fields" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDS = 'fields';

    /**
     * The name of the "template" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE = 'template';

    #endregion

    #endregion

    #region PUBLIC METHODS

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

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated fields.
     *
     * @return HasMany
     */
    final public function fields(): HasMany
    {
        return $this
            ->hasMany(
                EntityField::class,
                EntityField::ENTITY_UUID,
                self::UUID,
            )
            ->whereNull(EntityField::ENTITY_BLOCK_UUID);
    }

    /**
     * Get the associated template.
     *
     * @return BelongsTo
     */
    final public function template(): BelongsTo
    {
        return $this
            ->belongsTo(
                Template::class,
                self::TEMPLATE_ID,
                Template::ID,
            );
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function maxRevisions(): ?int
    {
        return 10;
    }

    #endregion
}
