<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SwitchInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param Template $template
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        $this->description($template->{Template::NAME});
        $this->title($template->{Template::NAME});

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function form(): array
    {
        return [
            static::mainBlock([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
            ]),
            static::sidebar([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::ENABLED,
                        Field::NAME => trans('narsil-cms::validation.attributes.enabled'),
                        Field::TYPE => SwitchInput::class,
                        Field::SETTINGS => app(SwitchInput::class)
                            ->checked(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Site::PRIMARY,
                        Field::NAME => trans('narsil-cms::validation.attributes.primary'),
                        Field::TYPE => SwitchInput::class,
                        Field::SETTINGS => app(SwitchInput::class),
                    ])
                ]),
            ]),
            static::informationBlock(),
        ];
    }

    #endregion
}
