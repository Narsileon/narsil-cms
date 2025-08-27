<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SectionElement as Contract;
use Narsil\Implementations\AbstractField;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SectionElement extends AbstractField implements Contract
{
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
        return 'section';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil::fields.section');
    }

    #endregion
}
