<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Narsil\Contracts\Form;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;
use ReflectionClass;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm implements Form
{
    #region PROPERTIES

    /**
     * @var string
     */
    public readonly string $method;
    /**
     * @var string
     */
    public readonly string $submit;
    /**
     * @var string
     */
    public readonly string $url;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array<Field>
     */
    abstract public function elements(): array;

    /**
     * {@inheritDoc}
     */
    public function get(
        string $url,
        MethodEnum $method,
        string $submit,
    ): array
    {
        $this->method = $method->value;
        $this->submit = $submit;
        $this->url = $url;

        $this->registerLabels();

        return [
            'elements' => $this->elements(),
            'id'     => $this->id(),
            'method' => $this->method,
            'submit' => $this->submit,
            'url'    => $this->url,
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param array $attribute
     * @param array $elements
     *
     * @return Block
     */
    protected function block(array $attribute = [], array $elements = []): Block
    {
        $block = new Block($attribute);

        $block->setRelation(Block::RELATION_ELEMENTS, collect($elements));

        return $block;
    }

    /**
     * @param Model $element
     * @param array<string,mixed> $attribute
     * @param array<BlockElementCondition> $conditions
     *
     * @return BlockElement
     */
    protected function blockElement(
        Model $element,
        array $attribute = [],
        array $conditions = []
    ): BlockElement
    {
        $block = new BlockElement($attribute);

        $block->setRelation(BlockElement::RELATION_CONDITIONS, collect($conditions));
        $block->setRelation(BlockElement::RELATION_ELEMENT, $element);

        return $block;
    }

    /**
     * @return string
     */
    protected function id(): string
    {
        $name = (new ReflectionClass(static::class))->getShortName();

        return Str::slug(Str::snake($name));
    }

    /**
     * @param ?array $elements
     *
     * @return Block
     */
    protected function informationBlock(?array $elements = null): Block
    {
        return $this->block(
            attribute: [
                Block::NAME => trans('narsil-cms::ui.information'),
                Block::HANDLE => 'information',
            ],
            elements: [
                $this->blockElement(
                    new Field([
                        Field::HANDLE => 'id',
                        Field::NAME => trans('narsil-cms::validation.attributes.id'),
                    ])
                ),
                $this->blockElement(
                    new Field([
                        Field::HANDLE => 'created_at',
                        Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                    ])
                ),
                $this->blockElement(
                    new Field([
                        Field::HANDLE => 'updated_at',
                        Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                    ])
                ),
            ],
        );
    }

    /**
     * @param array $elements
     *
     * @return Block
     */
    protected function mainBlock(array $elements): Block
    {
        return $this->block(
            attribute: [
                Block::NAME => trans('narsil-cms::ui.main'),
                Block::HANDLE => 'main',
            ],
            elements: $elements
        );
    }

    /**
     * @param array $elements
     *
     * @return Block
     */
    protected function sidebar(array $elements): Block
    {
        return $this->block(
            attribute: [
                Block::NAME => trans('narsil-cms::ui.sidebar'),
                Block::HANDLE => 'sidebar',
            ],
            elements: $elements
        );
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('narsil-cms::accessibility.align_center')
            ->add('narsil-cms::accessibility.align_justify')
            ->add('narsil-cms::accessibility.align_left')
            ->add('narsil-cms::accessibility.align_right')
            ->add('narsil-cms::accessibility.redo')
            ->add('narsil-cms::accessibility.required')
            ->add('narsil-cms::accessibility.toggle_bold')
            ->add('narsil-cms::accessibility.toggle_bullet_list')
            ->add('narsil-cms::accessibility.toggle_heading_1')
            ->add('narsil-cms::accessibility.toggle_heading_2')
            ->add('narsil-cms::accessibility.toggle_heading_3')
            ->add('narsil-cms::accessibility.toggle_heading_4')
            ->add('narsil-cms::accessibility.toggle_heading_5')
            ->add('narsil-cms::accessibility.toggle_heading_6')
            ->add('narsil-cms::accessibility.toggle_heading_menu')
            ->add('narsil-cms::accessibility.toggle_italic')
            ->add('narsil-cms::accessibility.toggle_ordered_list')
            ->add('narsil-cms::accessibility.toggle_strike')
            ->add('narsil-cms::accessibility.toggle_subscript')
            ->add('narsil-cms::accessibility.toggle_superscript')
            ->add('narsil-cms::accessibility.toggle_underline')
            ->add('narsil-cms::accessibility.undo')
            ->add('narsil-cms::pagination.empty')
            ->add('narsil-cms::ui.back');
    }

    #endregion
}
