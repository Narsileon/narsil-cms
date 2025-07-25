<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldCondition;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface AbstractField
{
    #region PUBLIC METHODS

    /**
     * @return array<Field>
     */
    public function getForm(): array;

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array;

    /**
     * @param string $className
     *
     * @return static Returns the current object instance.
     */
    public function className(string $className): static;

    /**
     * @param array<FieldCondition> $conditions
     *
     * @return static Returns the current object instance.
     */
    public function visiblityConditions(array $conditions): static;

    /**
     * @param string $mode
     *
     * @return static Returns the current object instance.
     */
    public function visiblityMode(string $mode): static;

    #endregion
}
