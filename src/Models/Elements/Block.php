<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Block extends Model
{
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

        parent::__construct($attributes);

        if ($elements = Arr::get($attributes, self::RELATION_ELEMENTS))
        {
            $this->setRelation(self::RELATION_ELEMENTS, collect($elements));
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "handle" column.
     */
    final public const HANDLE = 'handle';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';

    /**
     * @var string The name of the "blocks" count.
     */
    final public const COUNT_BLOCKS = 'blocks_count';
    /**
     * @var string The name of the "elements" count.
     */
    final public const COUNT_ELEMENTS = 'elements_count';
    /**
     * @var string The name of the "fields" count.
     */
    final public const COUNT_FIELDS = 'fields_count';

    /**
     * @var string The name of the "blocks" relation.
     */
    final public const RELATION_BLOCKS = 'blocks';
    /**
     * @var string The name of the "elements" relation.
     */
    final public const RELATION_ELEMENTS = 'elements';
    /**
     * @var string The name of the "fields" relation.
     */
    final public const RELATION_FIELDS = 'fields';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'blocks';

    #endregion

    #region RELATIONS

    /**
     * @return MorphToMany
     */
    public function blocks(): MorphToMany
    {
        return $this->morphedByMany(
            Block::class,
            BlockElement::RELATION_ELEMENT,
            BlockElement::TABLE,
            BlockElement::BLOCK_ID,
            BlockElement::ELEMENT_ID,
        );
    }

    /**
     * @return HasMany
     */
    public function elements(): HasMany
    {
        return $this->hasMany(
            BlockElement::class,
            BlockElement::BLOCK_ID,
            self::ID,
        );
    }

    /**
     * @return MorphToMany
     */
    public function fields(): MorphToMany
    {
        return $this->morphedByMany(
            Field::class,
            BlockElement::RELATION_ELEMENT,
            BlockElement::TABLE,
            BlockElement::BLOCK_ID,
            BlockElement::ELEMENT_ID,
        );
    }

    #endregion
}
