<?php

namespace Narsil\Fields\Select;

#region USE

use Narsil\Contracts\Fields\Select\SelectFieldSettings as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SelectFieldSettings extends FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TypeEnum::SELECT->value);

        $this->value('');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getForm(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    final public function options(array $options): static
    {
        $this->settings[PropEnum::OPTIONS->value] = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->settings[PropEnum::PLACEHOLDER->value] = $placeholder;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->settings[PropEnum::REQUIRED->value] = $required;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(string $value): static
    {
        $this->settings[PropEnum::VALUE->value] = $value;

        return $this;
    }

    #endregion
}
