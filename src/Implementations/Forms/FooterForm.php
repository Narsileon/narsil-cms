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
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
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
    protected function getLayout(): array
    {
        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::SLUG,
                            Field::LABEL => trans('narsil::validation.attributes.slug'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::LOGO,
                            Field::LABEL => trans('narsil::validation.attributes.logo'),
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::COMPANY,
                            Field::LABEL => trans('narsil::validation.attributes.company'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::ADDRESS_LINE_1,
                            Field::LABEL => trans('narsil::validation.attributes.address_line_1'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::ADDRESS_LINE_2,
                            Field::LABEL => trans('narsil::validation.attributes.address_line_2'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::EMAIL,
                            Field::LABEL => trans('narsil::validation.attributes.email'),
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::PHONE,
                            Field::LABEL => trans('narsil::validation.attributes.phone'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'meta_navigation',
                TemplateTab::LABEL => trans('narsil::ui.meta_navigation'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::RELATION_LINKS,
                            Field::LABEL => trans('narsil::ui.links'),
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form([
                                    new Field([
                                        Field::HANDLE => FooterLink::LABEL,
                                        Field::LABEL => trans('narsil::validation.attributes.label'),
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ]),
                                    new Field([
                                        Field::HANDLE => FooterLink::SITE_PAGE_ID,
                                        Field::LABEL => trans('narsil::validation.attributes.site_page_id'),
                                        Field::REQUIRED => true,
                                        Field::TYPE => SelectField::class,
                                        Field::SETTINGS => app(SelectField::class)
                                            ->href(route('site-pages.search')),
                                    ]),
                                ])
                                ->labelKey(FooterLink::LABEL),
                        ]),
                    ]),
                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'social_media',
                TemplateTab::LABEL => trans('narsil::ui.social_media'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::RELATION_SOCIAL_MEDIA,
                            Field::LABEL => trans('narsil::ui.links'),
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form([
                                    new Field([
                                        Field::HANDLE => FooterSocialMedium::LABEL,
                                        Field::LABEL => trans('narsil::validation.attributes.label'),
                                        Field::REQUIRED => true,
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ]),
                                    new Field([
                                        Field::HANDLE => FooterSocialMedium::URL,
                                        Field::LABEL => trans('narsil::validation.attributes.url'),
                                        Field::REQUIRED => true,
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ]),
                                ])
                                ->labelKey(FooterSocialMedium::LABEL),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
