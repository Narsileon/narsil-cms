<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\PasswordInput as Contract;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

        app(LabelsBag::class)
            ->add('narsil::accessibility.hide_password')
            ->add('narsil::accessibility.show_password');
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

    #endregion
}
