<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Facades\App;
use Locale;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Fields\SwitchInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Support\SelectOption;
use ResourceBundle;

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
        $this->description(trans('narsil-cms::ui.site'));
        $this->title(trans('narsil-cms::ui.site'));

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        $groupOptions = static::getGroupOptions();
        $languageOptions = static::getLanguageOptions();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::LANGUAGE,
                        Field::NAME => trans('narsil-cms::validation.attributes.language'),
                        Field::TYPE => SelectInput::class,
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($languageOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search'))
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::GROUP_ID,
                        Field::NAME => trans('narsil-cms::validation.attributes.group'),
                        Field::TYPE => SelectInput::class,
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($groupOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search')),
                    ])
                ]),
            ]),
            static::sidebarSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::ENABLED,
                        Field::NAME => trans('narsil-cms::validation.attributes.enabled'),
                        Field::TYPE => SwitchInput::class,
                        Field::SETTINGS => app(SwitchInput::class)
                            ->checked(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::PRIMARY,
                        Field::NAME => trans('narsil-cms::validation.attributes.primary'),
                        Field::TYPE => SwitchInput::class,
                        Field::SETTINGS => app(SwitchInput::class),
                    ])
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected static function getGroupOptions(): array
    {
        $groups = SiteGroup::query()
            ->orderBy(SiteGroup::NAME)
            ->get();

        $options = [];

        foreach ($groups as $group)
        {
            $options[] = new SelectOption($group->{SiteGroup::NAME}, $group->{SiteGroup::ID});
        }

        return $options;
    }

    /**
     * @return array<string>
     */
    protected static function getLanguageOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $options = [];

        foreach ($locales as $locale)
        {
            $options[] = (new SelectOption(
                label: Locale::getDisplayName($locale, App::getLocale()),
                value: $locale
            ))->jsonSerialize();
        }

        usort($options, function ($a, $b)
        {
            return strcmp($a['label'], $b['label']);
        });


        return array_values($options);
    }

    #endregion
}
