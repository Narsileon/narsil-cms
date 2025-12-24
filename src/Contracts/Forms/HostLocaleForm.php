<?php

namespace Narsil\Contracts\Forms;

#region USE

use Narsil\Contracts\Form;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/forms.php
 */
interface HostLocaleForm extends Form
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public function getCountryField(): Field;

    /**
     * @return Field
     */
    public function getLanguagesField(): Field;

    /**
     * @return Field
     */
    public function getPatternField(): Field;

    #endregion
}
