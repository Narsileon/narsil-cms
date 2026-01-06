<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
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
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::NAME => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Host::HOST,
                            Field::NAME => trans('narsil::validation.attributes.host'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Host::LABEL,
                            Field::NAME => trans('narsil::validation.attributes.label'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),

                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'default_country',
                TemplateTab::NAME => trans('narsil::ui.default_country'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::PATTERN,
                        TemplateTabElement::RELATION_ELEMENT => $hostLocaleForm->getPatternField(),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
                        TemplateTabElement::RELATION_ELEMENT => $hostLocaleForm->getLanguagesField(),
                    ]),
                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'other_countries',
                TemplateTab::NAME => trans('narsil::ui.other_countries'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
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
