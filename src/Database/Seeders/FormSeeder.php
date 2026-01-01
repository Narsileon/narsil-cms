<?php

namespace Narsil\Database\Seeders;

#region USE

use Narsil\Models\Forms\Form;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormSeeder extends FormsSeeder
{
    #region PUBLIC METHODS

    /**
     * @return Form
     */
    public function run(): Form
    {
        $form = $this->form();

        return $this->saveForm($form);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Form
     */
    abstract protected function form(): Form;

    #endregion
}
