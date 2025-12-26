<?php

namespace Narsil\Database\Seeders;

#region USE

use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FieldSeeder extends ElementSeeder
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public function run(): Field
    {
        $field = $this->field();

        return $this->saveField($field);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Field
     */
    abstract protected function field(): Field;

    #endregion
}
