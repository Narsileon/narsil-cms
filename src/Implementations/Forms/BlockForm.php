<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\BlockForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        return [
            $this->main([
                [
                    Field::HANDLE => Block::NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => Block::HANDLE,
                    Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => Block::RELATION_ELEMENTS,
                    Field::NAME => trans('narsil-cms::ui.fields'),
                    Field::SETTINGS => app(RelationsInput::class)
                        ->create(route('fields.create'))
                        ->labelKey(BlockElement::RELATION_ELEMENT . '.name')
                        ->toArray(),
                ],
            ]),
            $this->information([
                [
                    Field::HANDLE => Field::ID,
                    Field::NAME => trans('narsil-cms::validation.attributes.id'),
                ],
                [
                    Field::HANDLE => Field::CREATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                ],
                [
                    Field::HANDLE => Field::UPDATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                ],
            ]),
        ];
    }

    #endregion
}
