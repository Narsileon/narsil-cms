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
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        $groupOptions = $this->getGroupOptions();
        $languageOptions = $this->getLanguageOptions();

        return [
            $this->mainBlock([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::LANGUAGE,
                        Field::NAME => trans('narsil-cms::validation.attributes.language'),
                        Field::TYPE => SelectInput::class,
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($languageOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search'))
                            ->required(true)
                            ->search(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::GROUP_ID,
                        Field::NAME => trans('narsil-cms::validation.attributes.group'),
                        Field::TYPE => SelectInput::class,
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($groupOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search'))
                            ->search(true)
                            ->toArray(),
                    ])
                ]),
            ]),
            $this->sidebar([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::ENABLED,
                        Field::NAME => trans('narsil-cms::validation.attributes.enabled'),
                        Field::TYPE => SwitchInput::class,
                        Field::SETTINGS => app(SwitchInput::class)
                            ->checked(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::PRIMARY,
                        Field::NAME => trans('narsil-cms::validation.attributes.primary'),
                        Field::TYPE => SwitchInput::class,
                        Field::SETTINGS => app(SwitchInput::class)
                            ->toArray(),
                    ])
                ]),
            ]),
            $this->informationBlock(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected function getGroupOptions(): array
    {
        $groups = SiteGroup::query()
            ->orderBy(SiteGroup::NAME)
            ->get();

        $options = [];

        foreach ($groups as $group)
        {
            $options[] = [
                'value' => $group->{SiteGroup::ID},
                'label' => $group->{SiteGroup::NAME},
            ];
        }

        return $options;
    }

    /**
     * @return array<string>
     */
    protected function getLanguageOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $options = [];

        foreach ($locales as $locale)
        {
            $options[] = [
                'value' => $locale,
                'label' => Locale::getDisplayName($locale, App::getLocale()),
            ];
        }

        usort($options, function ($a, $b)
        {
            return strcmp($a['label'], $b['label']);
        });


        return array_values($options);
    }

    #endregion
}
