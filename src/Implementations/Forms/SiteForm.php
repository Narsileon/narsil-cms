<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Contracts\Forms\SiteSubdomainForm;
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
        $subdomainForm = app(SiteSubdomainForm::class)
            ->layout();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::DOMAIN,
                        Field::NAME => trans('narsil::validation.attributes.domain'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::PATTERN,
                        Field::NAME => trans('narsil::validation.attributes.pattern'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::RELATION_SUBDOMAINS,
                        Field::NAME => trans('narsil::validation.attributes.subdomains'),
                        Field::TYPE => ArrayField::class,
                        Field::SETTINGS => app(ArrayField::class)
                            ->setForm($subdomainForm)
                            ->setLabelKey(SiteSubdomain::SUBDOMAIN),
                    ]),
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion
}
