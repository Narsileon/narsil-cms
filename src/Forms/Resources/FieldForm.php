<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Select\SelectField;
use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Resources\FieldForm as Contract;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    public function content(): array
    {
        $typeOptions = $this->getTypeOptions();

        return [
            new Field([
                Field::HANDLE => Field::NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.name'),
                Field::SETTINGS => app(TextField::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Field::HANDLE,
                Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                Field::SETTINGS => app(TextField::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => Field::TYPE,
                Field::NAME => trans('narsil-cms::validation.attributes.type'),
                Field::SETTINGS => app(SelectField::class)
                    ->options($typeOptions)
                    ->placeholder(trans('narsil-cms::placeholders.search'))
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function meta(): array
    {
        return [
            new Field([
                Field::HANDLE => Field::ID,
                Field::NAME => trans('narsil-cms::validation.attributes.id'),
            ]),
            new Field([
                Field::HANDLE => Field::CREATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
            ]),
            new Field([
                Field::HANDLE => Field::UPDATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
            ]),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected function getTypeOptions(): array
    {
        $fields = app()->tagged('fields');

        $options = [];

        foreach ($fields as $field)
        {
            $options[] = [
                'icon' => $field->icon,
                'label' => $field->label,
                'value' => $field::class,
            ];
        }

        return $options;
    }

    #endregion
}
