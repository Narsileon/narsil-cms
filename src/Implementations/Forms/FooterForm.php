<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FooterForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\FooterLegalLink;
use Narsil\Models\Globals\FooterSocialLink;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->description(trans('narsil::models.' . Footer::class))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::models.' . Footer::class));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $footerLegalLinkForm = app(FooterLegalLinkForm::class);
        $footerSocialLinkForm = app(FooterSocialLinkForm::class);

        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'definition',
                TemplateSection::NAME => trans('narsil::ui.definition'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->required(true),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::LOGO,
                            Field::NAME => trans('narsil::validation.attributes.logo'),
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::COMPANY,
                            Field::NAME => trans('narsil::validation.attributes.company'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::ADDRESS_LINE_1,
                            Field::NAME => trans('narsil::validation.attributes.address_line_1'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::ADDRESS_LINE_2,
                            Field::NAME => trans('narsil::validation.attributes.address_line_2'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::EMAIL,
                            Field::NAME => trans('narsil::validation.attributes.email'),
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::PHONE,
                            Field::NAME => trans('narsil::validation.attributes.phone'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::RELATION_LEGAL_LINKS,
                            Field::NAME => trans('narsil::validation.attributes.legal_links'),
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form($footerLegalLinkForm->layout)
                                ->labelKey(FooterLegalLink::LABEL),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Footer::RELATION_SOCIAL_LINKS,
                            Field::NAME => trans('narsil::validation.attributes.social_links'),
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form($footerSocialLinkForm->layout)
                                ->labelKey(FooterSocialLink::LABEL),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
