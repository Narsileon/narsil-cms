<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TreeField;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Hosts\Host;

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
        return [
            new TemplateSection([
                TemplateSection::HANDLE => Host::RELATION_PAGES,
                TemplateSection::NAME => trans('narsil::ui.navigation'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Host::RELATION_PAGES,
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
}
