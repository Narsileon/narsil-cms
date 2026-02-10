<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Fields\BuilderField as Contract;
use Narsil\Cms\Contracts\Fields\RelationsField;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Services\RouteService;
use Narsil\Cms\Support\SelectOption;

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
            ->add('narsil-cms::dialogs.buttons.all_languages')
            ->add('narsil-cms::dialogs.buttons.this_language')
            ->add('narsil-cms::dialogs.descriptions.activation')
            ->add('narsil-cms::dialogs.descriptions.deactivation')
            ->add('narsil-cms::dialogs.titles.activation')
            ->add('narsil-cms::dialogs.titles.deactivation')
            ->add('narsil-cms::ui.collapse')
            ->add('narsil-cms::ui.expand')
            ->add('narsil-cms::ui.move_down')
            ->add('narsil-cms::ui.move_up')
            ->add('narsil-cms::ui.remove');
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
