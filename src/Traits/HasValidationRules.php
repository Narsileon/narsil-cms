<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasValidationRules
{
    #region CONSTANTS

    #region • COUNTS

    /**
     * The name of the "validation rules" count.
     *
     * @var string
     */
    final public const COUNT_VALIDATION_RULES = 'validation_rules_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "validation rules" relation.
     *
     * @var string
     */
    final public const RELATION_VALIDATION_RULES = 'validation_rules';

    #endregion

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated validation rules.
     *
     * @return BelongsToMany
     */
    abstract public function validation_rules(): BelongsToMany;

    #endregion

    #endregion
}
