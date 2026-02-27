<?php

namespace Narsil\Cms\Http\Data\Forms\Inputs;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\InputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\RouteService;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property array $defaultValue The value of the "default value" attribute.
 * @property FieldsetData[] $elements The value of the "elements" attribute.
 */
class BuilderInputData extends InputData
{
    #region CONSTRUCTOR

    /**
     * @param array $defaultValue The value of the "default value" attribute.
     * @param FieldsetData[] $elements The value of the "elements" attribute.
     *
     * @return void
     */
    public function __construct(
        array $defaultValue = [],
        array $elements = [],
    )
    {
        $this->set(self::DEFAULT_VALUE, $defaultValue);
        $this->set(self::ELEMENTS, $elements);

        parent::__construct(static::TYPE);
    }

    #endregion

    #region CONSTANTS

    /**
     * The name of the "elements" attribute.
     *
     * @var string
     */
    final public const ELEMENTS = 'elements';

    /**
     * The name of the "type" attribute.
     *
     * @var string
     */
    final public const TYPE = 'builder';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getInputForm(?string $prefix = null): array
    {
        $blockOptions = static::getBlockOptions();

        return [
            new FieldData(
                id: Field::RELATION_BLOCKS,
                label: ModelService::getTableLabel(Block::TABLE),
                prefix: $prefix,
                input: new RelationsInputData()
                    ->addOption(
                        identifier: Block::TABLE,
                        label: ModelService::getModelLabel(Block::TABLE),
                        optionLabel: Block::LABEL,
                        optionValue: Block::HANDLE,
                        options: $blockOptions,
                        routes: RouteService::getNames(Block::TABLE),
                    ),
            ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function registerTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::dialogs.buttons.all_languages')
            ->add('narsil-cms::dialogs.buttons.this_language')
            ->add('narsil-cms::dialogs.descriptions.activation')
            ->add('narsil-cms::dialogs.descriptions.deactivation')
            ->add('narsil-cms::dialogs.titles.activation')
            ->add('narsil-cms::dialogs.titles.deactivation')
            ->add('narsil::ui.collapse')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.expand')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the block options.
     *
     * @return OptionData[]
     */
    protected static function getBlockOptions(): array
    {
        return Block::query()
            ->orderBy(Block::LABEL)
            ->get()
            ->map(function (Block $block)
            {
                $option = new OptionData(
                    label: $block->getTranslations(Block::LABEL),
                    value: $block->{Block::HANDLE},
                )
                    ->icon($block->{Block::ATTRIBUTE_ICON})
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
