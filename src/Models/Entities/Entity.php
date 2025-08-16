<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\EntityElement;
use Narsil\Traits\HasDatetimes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Entity extends Model
{
    use HasDatetimes;
    use SoftDeletes;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_ELEMENTS,
            self::RELATION_TEMPLATE,
        ], $this->with);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "deleted at" column.
     */
    final public const DELETED_AT = 'deleted_at';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "template id" column.
     */
    final public const TEMPLATE_ID = 'template_id';
    /**
     * @var string The name of the "uuid" column.
     */
    final public const UUID = 'uuid';

    /**
     * @var string The name of the "elements" relation.
     */
    final public const RELATION_ELEMENTS = 'elements';
    /**
     * @var string The name of the "template" relation.
     */
    final public const RELATION_TEMPLATE = 'template';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'entities';

    #endregion

    #region RELATIONS

    /**
     * @return HasMany
     */
    public function elements(): HasMany
    {
        return $this
            ->hasMany(
                EntityElement::class,
                EntityElement::ENTITY_UUID,
                self::UUID,
            );
    }

    /**
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this
            ->belongsTo(
                Template::class,
                self::TEMPLATE_ID,
                Template::ID,
            );
    }

    #endregion

    #region SCOPES

    /**
     * Scope a query to only include popular users.
     */
    #[Scope]
    protected function ofType(Builder $query, string $type): void
    {
        $query->whereRelation(self::RELATION_TEMPLATE, Template::HANDLE, '=', $type);
    }

    #endregion
}
