<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\DatetimeField;
use Narsil\Contracts\Forms\PermissionForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => Role::NAME,
                Field::NAME => trans('narsil::validation.attributes.published_from'),
                Field::TRANSLATABLE => true,
                Field::TYPE => DatetimeField::class,
                Field::SETTINGS => app(DatetimeField::class),
            ]),

            new Field([
                Field::HANDLE => Role::HANDLE,
                Field::NAME => trans('narsil::validation.attributes.published_to'),
                Field::TYPE => DatetimeField::class,
                Field::SETTINGS => app(DatetimeField::class),
            ]),
        ];
    }

    #endregion
}
