<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface FieldSettings
{
    #region PUBLIC METHODS

    /**
     * @param string $className
     *
     * @return static Returns the current object instance.
     */
    public function className(string $className): static;

    /**
     * @return array<Field>
     */
    public function getForm(): array;

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array;

    #endregion
}
