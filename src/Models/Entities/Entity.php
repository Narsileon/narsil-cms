<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Collections\Template;
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
abstract class Entity extends Model
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
        $this->table = static::TABLE;

        $this->guarded = [];

        $this->translatable = [
            self::SLUG,
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
    public const TABLE = 'entities';

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
     * The name of the "nodes" relation.
     *
     * @var string
     */
    final public const RELATION_NODES = 'nodes';

    /**
     * The name of the "template" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE = 'template';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated nodes.
     *
     * @return HasMany
     */
    final public function nodes(): HasMany
    {
        return $this
            ->hasMany(
                static::entityNodeClass(),
                EntityNode::OWNER_UUID,
                self::UUID,
            )
            ->orderBy(EntityNode::POSITION);
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
     * Get the class of the entity node.
     *
     * @return string
     */
    protected static function entityNodeClass(): string
    {
        return static::class . 'Node';
    }

    /**
     * {@inheritDoc}
     */
    protected static function maxRevisions(): ?int
    {
        return 10;
    }

    #region • ACCESSORS

    /**
     * Get the "identifier" attribute.
     *
     * @return string
     */
    protected function identifier(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                $key = $this->{self::ID};
                $table = $this->getTable();

                return !empty($key) ? "$table-$key" : $table;
            },
        );
    }

    #endregion

    #endregion
}
