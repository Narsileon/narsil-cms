<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldOption extends Model
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
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "field id" column.
     */
    final public const FIELD_ID = 'field_id';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "label" column.
     */
    final public const LABEL = 'label';
    /**
     * @var string The name of the "value" column.
     */
    final public const VALUE = 'value';

    /**
     * @var string The name of the "field" relation.
     */
    final public const RELATION_FIELD = 'field';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'field_options';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    public function field(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::FIELD_ID,
                Field::ID,
            );
    }

    #endregion
}
