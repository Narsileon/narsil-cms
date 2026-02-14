<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Fields\TreeField as Contract;
use Narsil\Cms\Implementations\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TreeField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue([]);

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function bootTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::ui.add_child')
            ->add('narsil-cms::ui.move_down')
            ->add('narsil-cms::ui.move_up')
            ->add('narsil-ui::ui.delete')
            ->add('narsil-ui::ui.edit');
    }

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(array $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    #endregion

    #endregion
}
