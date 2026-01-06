<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\DatetimeField;
use Narsil\Contracts\Forms\PermissionForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::CLASS_NAME => 'flex-row justify-between',
                Field::HANDLE => Entity::PUBLISHED_FROM,
                Field::LABEL => trans('narsil::validation.attributes.published_from'),
                Field::TYPE => DatetimeField::class,
                Field::SETTINGS => app(DatetimeField::class),
            ]),
            new Field([
                Field::CLASS_NAME => 'flex-row justify-between',
                Field::HANDLE => Entity::PUBLISHED_TO,
                Field::LABEL => trans('narsil::validation.attributes.published_to'),
                Field::TYPE => DatetimeField::class,
                Field::SETTINGS => app(DatetimeField::class),
            ]),
        ];
    }

    #endregion
}
