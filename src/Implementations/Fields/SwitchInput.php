<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SwitchInput as Contract;
use Narsil\Implementations\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SwitchInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->checked(false);
        $this->type('checkbox');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'toggle-right';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.switch');
    }

    /**
     * {@inheritDoc}
     */
    final public function checked(bool $value): static
    {
        $this->settings['checked'] = $value;

        return $this;
    }

    #endregion
}
