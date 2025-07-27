<?php

namespace Narsil\Fields\Text;

#region USE

use Narsil\Contracts\Fields\Text\PasswordField as Contract;
use Narsil\Enums\Fields\InputTypeEnum;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Fields\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PasswordField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            icon: 'rectangle-ellipsis',
            label: trans('narsil-cms::fields.password'),
            type: InputTypeEnum::PASSWORD->value
        );

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
    final public function autoComplete(string $autoComplete): static
    {
        $this->settings[PropEnum::AUTO_COMPLETE->value] = $autoComplete;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function maxLength(string $maxLength): static
    {
        $this->settings[PropEnum::MAX_LENGTH->value] = $maxLength;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function minLength(string $minLength): static
    {
        $this->settings[PropEnum::MIN_LENGTH->value] = $minLength;

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
