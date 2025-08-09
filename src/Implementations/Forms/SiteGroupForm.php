<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\SiteGroupForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Sites\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->description(trans('narsil-cms::ui.site_group'));
        $this->title(trans('narsil-cms::ui.site_group'));
        $this->url(route('site-groups.store'));

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
                        Field::HANDLE => SiteGroup::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ]),
                ]),
            ]),
            static::informationBlock(),
        ];
    }

    #endregion
}
