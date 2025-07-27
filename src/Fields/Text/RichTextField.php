<?php

namespace Narsil\Fields\Text;

#region USE

use Narsil\Contracts\Fields\Text\RichTextField as Contract;
use Narsil\Enums\Fields\InputTypeEnum;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Fields\AbstractField;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RichTextField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            icon: 'text-cursor-input',
            label: trans('narsil-cms::fields.rich_text'),
            type: InputTypeEnum::TEXT->value
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
        return [
            new Field([
                Field::HANDLE => 'placeholder',
                Field::NAME => trans('narsil-cms::validation.attributes.placeholder'),
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
        ];
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
