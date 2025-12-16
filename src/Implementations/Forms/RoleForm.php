<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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

        $this->routes(RouteService::getNames(Role::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $permissionSelectOptions = static::getPermissionSelectOptions();

        $permissionElements = $permissionSelectOptions
            ->sortBy(function ($options, $group)
            {
                return $group;
            })
            ->map(function ($options, $group)
            {
                return new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Role::RELATION_PERMISSIONS,
                        Field::NAME => $group,
                        Field::TYPE => CheckboxField::class,
                        Field::RELATION_OPTIONS => $options,
                        Field::SETTINGS => app(CheckboxField::class),
                    ]),
                ]);
            })
            ->values()
            ->toArray();

        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'definition',
                TemplateSection::NAME => trans('narsil::ui.definition'),
                TemplateSection::RELATION_ELEMENTS => [
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
                ],
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => Role::RELATION_PERMISSIONS,
                TemplateSection::NAME => Str::ucfirst(trans('narsil::tables.permissions')),
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
            ->groupBy(function (Permission $permission)
            {
                $key = Str::beforeLast($permission->{Permission::HANDLE}, '_');

                return trans("narsil::tables.{$key}");
            })
            ->map(function ($permissions)
            {
                return $permissions->map(function (Permission $permission)
                {
                    $option = new SelectOption()
                        ->optionLabel($permission->{Permission::NAME})
                        ->optionValue($permission->{Permission::HANDLE});

                    return $option;
                })->toArray();
            });
    }

    #endregion
}
