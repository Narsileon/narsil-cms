<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FooterForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Globals\FooterSocialMedium;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Footer::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Footer::SLUG,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.slug'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::LOGO,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.logo'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::COMPANY,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.company'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::ADDRESS_LINE_1,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.address_line_1'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::ADDRESS_LINE_2,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.address_line_2'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::EMAIL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.email'),
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::PHONE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.phone'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Footer::COPYRIGHT,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.copyright'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'meta_navigation',
                TemplateTab::LABEL => trans('narsil::ui.meta_navigation'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Footer::RELATION_LINKS,
                        TemplateTabElement::LABEL => trans('narsil::ui.links'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form([
                                    [
                                        BlockElement::HANDLE => FooterLink::LABEL,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.label'),
                                        BlockElement::TRANSLATABLE => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => FooterLink::SITE_PAGE_ID,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.site_page_id'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class)
                                                ->href(route('site-pages.search')),
                                        ],
                                    ],
                                ])
                                ->labelKey(FooterLink::LABEL),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'social_media',
                TemplateTab::LABEL => trans('narsil::ui.social_media'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Footer::RELATION_SOCIAL_MEDIA,
                        TemplateTabElement::LABEL => trans('narsil::ui.links'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form([
                                    [
                                        BlockElement::HANDLE => FooterSocialMedium::LABEL,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.label'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::TRANSLATABLE => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => FooterSocialMedium::URL,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.url'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                ])
                                ->labelKey(FooterSocialMedium::LABEL),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
