<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\BuilderField as Contract;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Services\ModelService;
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
            ->add('narsil::dialogs.buttons.all_languages')
            ->add('narsil::dialogs.buttons.this_language')
            ->add('narsil::dialogs.descriptions.activation')
            ->add('narsil::dialogs.descriptions.deactivation')
            ->add('narsil::dialogs.titles.activation')
            ->add('narsil::dialogs.titles.deactivation')
            ->add('narsil::ui.collapse')
            ->add('narsil::ui.expand')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up')
            ->add('narsil::ui.remove');
    }

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        $blockSelectOptions = static::getBlockSelectOptions();

        return [
            [
                BlockElement::HANDLE => Field::RELATION_BLOCKS,
                BlockElement::LABEL => ModelService::getTableLabel(Block::TABLE),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => RelationsField::class,
                    Field::SETTINGS => app(RelationsField::class)
                        ->addOption(
                            identifier: Block::TABLE,
                            label: ModelService::getModelLabel(Block::class),
                            optionLabel: Block::LABEL,
                            optionValue: Block::HANDLE,
                            options: $blockSelectOptions,
                            routes: RouteService::getNames(Block::TABLE),
                        )
                        ->unique(true),
                ],
            ],
        ];
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
            ->orderBy(Block::LABEL)
            ->get()
            ->map(function (Block $block)
            {
                $option = new SelectOption()
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($block->{Block::ATTRIBUTE_ICON})
                    ->optionLabel($block->getTranslations(Block::LABEL))
                    ->optionValue($block->{Block::HANDLE});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
