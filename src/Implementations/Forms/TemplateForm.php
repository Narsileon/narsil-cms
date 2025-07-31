<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        return [
            $this->mainBlock([
                $this->blockElement(
                    new Field([
                        Field::HANDLE => Template::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ),
                $this->blockElement(
                    new Field([
                        Field::HANDLE => Template::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ),
                $this->blockElement(
                    new Field([
                        Block::HANDLE => FIELD::SETTINGS,
                        Block::NAME => trans('narsil-cms::ui.fields'),
                        Block::RELATION_ELEMENTS => [],
                    ])
                ),
            ]),
            $this->informationBlock(),
        ];
    }

    #endregion
}
