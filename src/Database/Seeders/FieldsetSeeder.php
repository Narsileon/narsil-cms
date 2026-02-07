<?php

namespace Narsil\Cms\Database\Seeders;

#region USE

use Narsil\Cms\Form\Models\Fieldset;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FieldsetSeeder extends FormsSeeder
{
    #region PUBLIC METHODS

    /**
     * @return Fieldset
     */
    public function run(): Fieldset
    {
        $fieldset = $this->fieldset();

        return $this->saveFieldset($fieldset);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Fieldset
     */
    abstract protected function fieldset(): Fieldset;

    #endregion
}
