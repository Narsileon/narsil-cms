<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSection;
use Narsil\Models\Structures\TemplateSectionElement;
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
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

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
                ],
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'default_country',
                TemplateSection::NAME => trans('narsil::ui.default_country'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::PATTERN,
                        TemplateSectionElement::RELATION_ELEMENT => $hostLocaleForm->getPatternField(),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
                        TemplateSectionElement::RELATION_ELEMENT => $hostLocaleForm->getLanguagesField(),
                    ]),
                ],
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'other_countries',
                TemplateSection::NAME => trans('narsil::ui.other_countries'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
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
        ];
    }

    #endregion
}
