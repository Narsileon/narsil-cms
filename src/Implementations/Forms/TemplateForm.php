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
            $this->main([
                [
                    Field::HANDLE => Template::NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => Template::HANDLE,
                    Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Block::HANDLE => FIELD::SETTINGS,
                    Block::NAME => trans('narsil-cms::ui.fields'),
                    Block::RELATION_ELEMENTS => [],
                ]
            ]),
            $this->information([
                [
                    Field::HANDLE => Template::ID,
                    Field::NAME => trans('narsil-cms::validation.attributes.id'),
                ],
                [
                    Field::HANDLE => Template::CREATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                ],
                [
                    Field::HANDLE => Template::UPDATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                ],
            ]),
        ];
    }

    #endregion
}
