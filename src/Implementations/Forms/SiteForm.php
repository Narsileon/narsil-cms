<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteSubdomain;
use Narsil\Models\Sites\SiteSubdomainLanguage;
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
                            ->setForm([
                                new Field([
                                    Field::HANDLE => SiteSubdomain::SUBDOMAIN,
                                    Field::NAME => trans('narsil::validation.attributes.subdomain'),
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class)
                                        ->setRequired(true),
                                ]),
                                new Field([
                                    Field::HANDLE => SiteSubdomain::RELATION_LANGUAGES,
                                    Field::NAME => trans('narsil::validation.attributes.languages'),
                                    Field::TYPE => TableField::class,
                                    Field::SETTINGS => app(TableField::class)
                                        ->setColumns([
                                            new Field([
                                                Field::HANDLE => SiteSubdomainLanguage::LANGUAGE,
                                                Field::NAME => trans('narsil::validation.attributes.language'),
                                                Field::TYPE => TextField::class,
                                                Field::SETTINGS => app(TextField::class)
                                                    ->setRequired(true),
                                            ]),
                                        ])
                                        ->setPlaceholder(trans('narsil::ui.add')),
                                ]),
                            ])
                            ->setLabelKey(SiteSubdomain::SUBDOMAIN),
                    ]),
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion
}
