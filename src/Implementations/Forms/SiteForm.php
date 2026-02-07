<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Cms\Contracts\Fields\SelectField;
use Narsil\Cms\Contracts\Fields\TreeField;
use Narsil\Cms\Contracts\Forms\SiteForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $headerSelectOptions = static::getHeaderSelectOptions();
        $footerSelectOptions = static::getFooterSelectOptions();

        return [
            [
                TemplateTab::HANDLE => Site::RELATION_PAGES,
                TemplateTab::LABEL => trans('narsil-cms::ui.navigation'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Site::HEADER_ID,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.header_id'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class),
                            Field::RELATION_OPTIONS => $headerSelectOptions,
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Site::FOOTER_ID,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.footer_id'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class),
                            Field::RELATION_OPTIONS => $footerSelectOptions,
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Site::RELATION_PAGES,
                        TemplateTabElement::LABEL => trans('narsil-cms::ui.navigation'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TreeField::class,
                            Field::SETTINGS => app(TreeField::class),
                        ],
                    ],
                ],
            ],
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
            ->orderBy(Footer::SLUG)
            ->get()
            ->map(function (Footer $footer)
            {
                $option = new SelectOption()
                    ->optionLabel($footer->{Footer::SLUG})
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
            ->orderBy(Header::SLUG)
            ->get()
            ->map(function (Header $header)
            {
                $option = new SelectOption()
                    ->optionLabel($header->{Header::SLUG})
                    ->optionValue((string)$header->{Header::ID});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
