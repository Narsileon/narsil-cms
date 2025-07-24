<?php

namespace Narsil\Fields\Text;

#region USE

use Narsil\Contracts\Fields\Enum\CheckboxFieldSettings;
use Narsil\Contracts\Fields\Text\EmailFieldSettings as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\FieldSettings;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EmailFieldSettings extends FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TypeEnum::EMAIL->value);

        $this->autoComplete('email');
        $this->value('');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getForm(): array
    {
        return [
            new Field([
                Field::HANDLE => 'multiple',
                Field::NAME => trans('validation.attributes.multiple'),
                Field::SETTINGS => app(CheckboxFieldSettings::class)
                    ->toArray(),
            ]),
        ];
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
    final public function multiple(bool $multiple): static
    {
        $this->settings[PropEnum::MAX_LENGTH->value] = $multiple;

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
