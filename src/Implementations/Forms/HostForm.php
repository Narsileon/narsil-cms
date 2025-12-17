<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes(RouteService::getNames(Host::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $hostLocaleForm = app(HostLocaleForm::class);

        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'definition',
                TemplateSection::NAME => trans('narsil::ui.definition'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Host::NAME,
                            Field::NAME => trans('narsil::validation.attributes.name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Host::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Block([
                            Block::NAME => trans('narsil::ui.default'),
                            Block::RELATION_ELEMENTS => [
                                new BlockElement([
                                    BlockElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::PATTERN,
                                    BlockElement::RELATION_ELEMENT => $hostLocaleForm->getPatternField(),
                                ]),
                                new BlockElement([
                                    BlockElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
                                    BlockElement::RELATION_ELEMENT => $hostLocaleForm->getLanguagesField(),
                                ]),
                            ],
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Block([
                            Block::NAME => trans('narsil::ui.localization'),
                            Block::RELATION_ELEMENTS => [
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => Host::RELATION_OTHER_LOCALES,
                                        Field::NAME => trans('narsil::validation.attributes.locales'),
                                        Field::TYPE => ArrayField::class,
                                        Field::SETTINGS => app(ArrayField::class)
                                            ->form($hostLocaleForm->layout)
                                            ->labelKey(HostLocale::COUNTRY),
                                    ]),
                                ]),
                            ],
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
