<?php

namespace Narsil\Cms\Database\Seeders;

#region USE

use Narsil\Cms\Form\Models\Form;

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
