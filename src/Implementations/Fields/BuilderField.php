<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\BuilderField as Contract;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BuilderField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue([]);

        app(TranslationsBag::class)
            ->add('narsil::ui.collapse')
            ->add('narsil::ui.expand')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up')
            ->add('narsil::ui.remove');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        $blockSelectOptions = static::getBlockSelectOptions();

        return [
            new Field([
                Field::HANDLE => Field::RELATION_BLOCKS,
                Field::NAME => trans('narsil::tables.' . Block::TABLE),
                Field::TYPE => RelationsField::class,
                Field::SETTINGS => app(RelationsField::class)
                    ->addOption(
                        identifier: Block::TABLE,
                        label: trans('narsil::models.' . Block::class),
                        optionLabel: Block::NAME,
                        optionValue: Block::HANDLE,
                        options: $blockSelectOptions,
                        routes: RouteService::getNames(Block::TABLE),
                    )
                    ->unique(true),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'box';
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

    #region PROTECTED METHODS

    /**
     * Get the block select options.
     *
     * @return array<SelectOption>
     */
    protected static function getBlockSelectOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                $option = new SelectOption()
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($block->{Block::ATTRIBUTE_ICON})
                    ->optionLabel($block->getTranslations(Block::NAME))
                    ->optionValue($block->{Block::HANDLE});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
