<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\PasswordInput as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PasswordInput extends TextInput implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->type('password');
        $this->value('');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'password';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.password');
    }

    #endregion
}
