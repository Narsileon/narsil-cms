<?php

namespace Narsil\Database\Seeders;

#region USE

use Narsil\Models\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class InputSeeder extends FormsSeeder
{
    #region PUBLIC METHODS

    /**
     * @return Input
     */
    public function run(): Input
    {
        $input = $this->input();

        return $this->saveInput($input);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Input
     */
    abstract protected function input(): Input;

    #endregion
}
