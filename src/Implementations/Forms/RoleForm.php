<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\RoleForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Services\RouteService;
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

        $this
            ->description(trans('narsil::models.' . Role::class))
            ->routes(RouteService::getNames(Role::TABLE))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::models.' . Role::class));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $permissionSelectOptions = static::getPermissionSelectOptions();

        $permissionElements = $permissionSelectOptions->map(function ($options, $category)
        {
            return new TemplateSectionElement([
                TemplateSectionElement::RELATION_ELEMENT => new Field([
                    Field::HANDLE => Role::RELATION_PERMISSIONS,
                    Field::NAME => trans("narsil::tables.{$category}"),
                    Field::TYPE => CheckboxField::class,
                    Field::SETTINGS => app(CheckboxField::class)
                        ->options($options),
                ]),
            ]);
        })->values()->toArray();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Role::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->required(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Role::HANDLE,
                        Field::NAME => trans('narsil::validation.attributes.handle'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->required(true),
                    ]),
                ]),
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => Role::RELATION_PERMISSIONS,
                TemplateSection::NAME => trans('narsil::tables.permissions'),
                TemplateSection::RELATION_ELEMENTS => $permissionElements,
            ]),
        ];
    }

    /**
     * @return Collection<string,array<SelectOption>>
     */
    protected static function getPermissionSelectOptions(): Collection
    {
        return Permission::query()
            ->get()
            ->groupBy(Permission::CATEGORY)
            ->map(function ($permissions)
            {
                return $permissions->map(function (Permission $permission)
                {
                    $option = new SelectOption()
                        ->optionLabel($permission->{Permission::NAME})
                        ->optionValue($permission->{Permission::NAME});

                    return $option;
                })->toArray();
            });
    }

    #endregion
}
