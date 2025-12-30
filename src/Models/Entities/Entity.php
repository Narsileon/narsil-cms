<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Narsil\Models\Forms\Form;
use Narsil\Models\Sites\SitePage;
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
            self::RELATION_BLOCKS,
            self::RELATION_DATA,
            self::RELATION_ENTITIES,
            self::RELATION_FORMS,
            self::RELATION_SITE_PAGES,
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
     * The name of the "data" relation.
     *
     * @var string
     */
    final public const RELATION_DATA = 'data';

    /**
     * The name of the "entities" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITIES = 'entities';

    /**
     * The name of the "forms" relation.
     *
     * @var string
     */
    final public const RELATION_FORMS = 'forms';

    /**
     * The name of the "site pages" relation.
     *
     * @var string
     */
    final public const RELATION_SITE_PAGES = 'site_pages';

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
            ->whereNull(EntityBlock::ENTITY_BLOCK_FIELD_UUID);
    }

    /**
     * Get the associated data.
     *
     * @return HasOne
     */
    final public function data(): HasOne
    {
        return $this
            ->hasOne(
                EntityData::class,
                EntityData::ENTITY_UUID,
                self::UUID,
            );
    }

    /**
     * Get the associated entities.
     *
     * @return BelongsToMany
     */
    final public function entities(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Entity::class,
                EntityEntity::TABLE,
                EntityEntity::OWNER_UUID,
                EntityEntity::TARGET_UUID,
            )
            ->using(EntityEntity::class);
    }

    /**
     * Get the associated forms.
     *
     * @return BelongsToMany
     */
    final public function forms(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Form::class,
                EntityForm::TABLE,
                EntityForm::ENTITY_UUID,
                EntityForm::FORM_ID,
            )
            ->using(EntityForm::class);
    }

    /**
     * Get the associated site pages.
     *
     * @return BelongsToMany
     */
    final public function site_pages(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                SitePage::class,
                EntitySitePage::TABLE,
                EntitySitePage::ENTITY_UUID,
                EntitySitePage::SITE_PAGE_ID,
            )
            ->using(EntitySitePage::class);
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
