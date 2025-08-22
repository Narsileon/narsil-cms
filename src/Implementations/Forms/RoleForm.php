<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\RoleForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Support\SelectOption;

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

        $this->description = trans('narsil::models.role');
        $this->title = trans('narsil::models.role');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        $permissionOptions = static::getPermissionOptions();

        $permissionElements = $permissionOptions->map(function ($options, $category)
        {
            return new TemplateSectionElement([
                TemplateSectionElement::RELATION_ELEMENT =>
                new Field([
                    Field::HANDLE => Role::RELATION_PERMISSIONS,
                    Field::NAME => trans("narsil::ui.{$category}"),
                    Field::TYPE => CheckboxInput::class,
                    Field::SETTINGS => app(CheckboxInput::class)->options($options),
                ]),
            ]);
        })->values()->toArray();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Role::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ]),
                ]),
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => Role::RELATION_PERMISSIONS,
                TemplateSection::NAME => trans('narsil::tables.permissions'),
                TemplateSection::RELATION_ELEMENTS => $permissionElements,
            ]),
            static::informationSection(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Collection<string,array<Permission>>
     */
    protected static function getPermissionOptions(): Collection
    {
        return Permission::query()
            ->get()
            ->groupBy(Permission::CATEGORY)
            ->map(function ($permissions)
            {
                return $permissions->map(function (Permission $permission)
                {
                    return new SelectOption(
                        $permission->{Permission::NAME},
                        $permission->{Permission::NAME}
                    );
                })->toArray();
            });
    }

    #endregion
}
