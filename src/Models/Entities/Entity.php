<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Elements\Template;
use Narsil\Services\TemplateService;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasRevisions;
use Narsil\Traits\HasTemplate;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Entity extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasRevisions;
    use HasTemplate;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::getTableName();

        $this->primaryKey = self::UUID;

        $this->guarded = [];

        $this->with = [
            self::RELATION_BLOCKS,
        ];

        if (static::$template)
        {
            $casts = $this->generateCasts(TemplateService::getTemplateFields(static::$template));

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
            ->whereNull(EntityBlock::PARENT_UUID);
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
