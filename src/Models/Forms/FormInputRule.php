<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputRule extends Model
{
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

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'form_input_rules';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "input id" column.
     *
     * @var string
     */
    final public const INPUT_ID = 'input_id';

    /**
     * The name of the "rule" column.
     *
     * @var string
     */
    final public const RULE = 'rule';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "input" relation.
     *
     * @var string
     */
    final public const RELATION_INPUT = 'input';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated input.
     *
     * @return BelongsTo
     */
    final public function input(): BelongsTo
    {
        return $this
            ->belongsTo(
                FormInput::class,
                self::INPUT_ID,
                FormInput::ID,
            );
    }

    #endregion

    #endregion
}
