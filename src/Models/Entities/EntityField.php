<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Casts\JsonCast;
use Narsil\Models\Forms\Form;
use Narsil\Models\Sites\SitePage;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityField extends Model
{
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
        $this->timestamps = false;

        $this->translatable = [
            self::VALUE,
        ];

        $this->with = [
            self::RELATION_BLOCKS,
            self::RELATION_ELEMENT,
            self::RELATION_ENTITIES,
            self::RELATION_FORMS,
            self::RELATION_SITE_PAGES,
        ];

        $this->mergeCasts([
            self::VALUE => JsonCast::class,
        ]);

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
    final public const TABLE = 'entity_fields';

    #region • COLUMNS

    /**
     * The name of the "element id" column.
     *
     * @var string
     */
    final public const ELEMENT_ID = 'element_id';

    /**
     * The name of the "element type" column.
     *
     * @var string
     */
    final public const ELEMENT_TYPE = 'element_type';

    /**
     * The name of the "entity block uuid" column.
     *
     * @var string
     */
    final public const ENTITY_BLOCK_UUID = 'entity_block_uuid';

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    /**
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "element" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENT = 'element';

    /**
     * The name of the "entities" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITIES = 'entities';

    /**
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

    /**
     * The name of the "entity block" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_BLOCK = 'entity_block';

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

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated block.
     *
     * @return BelongsTo
     */
    final public function entity_block(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityBlock::class,
                self::ENTITY_BLOCK_UUID,
                EntityBlock::UUID,
            );
    }

    /**
     * Get the associated blocks.
     *
     * @return HasMany
     */
    public function blocks(): HasMany
    {
        return $this
            ->hasMany(
                EntityBlock::class,
                EntityBlock::ENTITY_FIELD_UUID,
                self::UUID,
            );
    }

    /**
     * Get the associated element.
     *
     * @return MorphTo
     */
    final public function element(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_ELEMENT,
                self::ELEMENT_TYPE,
                self::ELEMENT_ID,
            );
    }

    /**
     * Get the associated entity.
     *
     * @return BelongsTo
     */
    final public function entity(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::ENTITY_UUID,
                Entity::UUID,
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
                EntityFieldEntity::TABLE,
                EntityFieldEntity::ENTITY_FIELD_UUID,
                EntityFieldEntity::ENTITY_UUID,
            )
            ->using(EntityFieldEntity::class);
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
                EntityFieldForm::TABLE,
                EntityFieldForm::ENTITY_FIELD_UUID,
                EntityFieldForm::FORM_ID,
            )
            ->using(EntityFieldForm::class);
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
                EntityFieldSitePage::TABLE,
                EntityFieldSitePage::ENTITY_FIELD_UUID,
                EntityFieldSitePage::SITE_PAGE_ID,
            )
            ->using(EntityFieldSitePage::class);
    }

    #endregion

    #endregion
}
