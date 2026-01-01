<?php

namespace Narsil\Database\Seeders;

#region USE

use Narsil\Models\Structures\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TemplateSeeder extends StructuresSeeder
{
    #region PUBLIC METHODS

    /**
     * @return Template
     */
    public function run(): Template
    {
        $template = $this->template();

        return $this->saveTemplate($template);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Template
     */
    abstract protected function template(): Template;

    #endregion
}
