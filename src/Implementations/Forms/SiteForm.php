<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TreeField;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Sites\Site;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->description(trans('narsil::ui.site'))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::ui.site'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $headerSelectOptions = static::getHeaderSelectOptions();
        $footerSelectOptions = static::getFooterSelectOptions();

        return [
            new TemplateSection([
                TemplateSection::HANDLE => Site::RELATION_PAGES,
                TemplateSection::NAME => trans('narsil::ui.navigation'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Site::HEADER_ID,
                            Field::NAME => trans('narsil::validation.attributes.header_id'),
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->options($headerSelectOptions),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Site::FOOTER_ID,
                            Field::NAME => trans('narsil::validation.attributes.footer_id'),
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->options($footerSelectOptions),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Site::RELATION_PAGES,
                            Field::NAME => trans('narsil::ui.navigation'),
                            Field::TYPE => TreeField::class,
                            Field::SETTINGS => app(TreeField::class),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the footer select options.
     *
     * @return array<SelectOption>
     */
    protected static function getFooterSelectOptions(): array
    {
        return Footer::query()
            ->orderBy(Footer::HANDLE)
            ->get()
            ->map(function (Footer $footer)
            {
                $option = new SelectOption()
                    ->optionLabel($footer->{Footer::HANDLE})
                    ->optionValue((string)$footer->{Footer::ID});

                return $option;
            })
            ->toArray();
    }

    /**
     * Get the header select options.
     *
     * @return array<SelectOption>
     */
    protected static function getHeaderSelectOptions(): array
    {
        return Header::query()
            ->orderBy(Header::HANDLE)
            ->get()
            ->map(function (Header $header)
            {
                $option = new SelectOption()
                    ->optionLabel($header->{Header::HANDLE})
                    ->optionValue((string)$header->{Header::ID});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
