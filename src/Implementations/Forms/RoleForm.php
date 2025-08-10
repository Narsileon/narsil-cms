<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\RoleForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil-cms::ui.role');
        $this->title = trans('narsil-cms::ui.role');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Role::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ]),
                ]),
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'roles',
                TemplateSection::NAME => trans('narsil-cms::ui.roles'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT =>
                        new Field([
                            Field::HANDLE => Role::RELATION_PERMISSIONS,
                            Field::NAME => trans('narsil-cms::validation.attributes.permissions'),
                            Field::TYPE => CheckboxInput::class,
                            Field::SETTINGS => app(CheckboxInput::class),
                        ]),
                    ]),
                ],
            ]),
            static::informationSection(),
        ];
    }

    #endregion
}
