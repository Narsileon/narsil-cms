<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteSubdomain;
use Narsil\Services\RouteService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::models.site');
        $this->routes = RouteService::getNames(Site::TABLE);
        $this->submitLabel = trans('narsil::ui.save');
        $this->title = trans('narsil::models.site');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $subdomainForm = $this->getSubdomainForm();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::DOMAIN,
                        Field::NAME => trans('narsil::validation.attributes.domain'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::PATTERN,
                        Field::NAME => trans('narsil::validation.attributes.pattern'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::RELATION_SUBDOMAINS,
                        Field::NAME => trans('narsil::validation.attributes.subdomains'),
                        Field::TYPE => RelationsInput::class,
                        Field::SETTINGS => app(RelationsInput::class)
                            ->setForm($subdomainForm)
                            ->addOption(
                                identifier: SiteSubdomain::TABLE,
                                label: '',
                                optionLabel: SiteSubdomain::SUBDOMAIN,
                                optionValue: SiteSubdomain::ID,
                            ),
                    ]),
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<Field>
     */
    protected function getSubdomainForm(): array
    {
        return [
            new Field([
                Field::HANDLE => SiteSubdomain::SUBDOMAIN,
                Field::NAME => trans('narsil::validation.attributes.pattern'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => SiteSubdomain::RELATION_LANGUAGES,
                Field::NAME => trans('narsil::validation.attributes.subdomains'),
                Field::TYPE => RelationsInput::class,
                Field::SETTINGS => app(RelationsInput::class)
                    ->setOptions([]),
            ]),
        ];
    }

    #endregion
}
