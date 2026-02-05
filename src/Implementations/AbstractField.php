<?php

namespace Narsil\Cms\Implementations;

#region USE

use Illuminate\Support\Fluent;
use Narsil\Cms\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractField extends Fluent implements Field
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->bootTranslations(false);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function bootTranslations(): void
    {
        //
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function append(string $append): static
    {
        $this->set('append', $append);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function readOnly(bool $readOnly): static
    {
        $this->set('readOnly', $readOnly);

        return $this;
    }

    #endregion

    #endregion
}
