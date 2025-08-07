<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Form;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
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
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil-cms::pagination.empty')
            ->add('narsil-cms::placeholders.choose')
            ->add('narsil-cms::ui.back')
            ->add('narsil-cms::ui.create');
    }

    #endregion

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
        return new Block([
            Block::HANDLE => 'information',
            Block::NAME => trans('narsil-cms::ui.information'),
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'id',
                        Field::NAME => trans('narsil-cms::validation.attributes.id'),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'created_at',
                        Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'updated_at',
                        Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                    ])
                ]),
            ]
        ]);
    }

    /**
     * @param array $elements
     *
     * @return Block
     */
    protected function mainBlock(array $elements): Block
    {
        return new Block([
            Block::HANDLE => 'main',
            Block::NAME => trans('narsil-cms::ui.main'),
            Block::RELATION_ELEMENTS => $elements
        ]);
    }

    /**
     * @param array $elements
     *
     * @return Block
     */
    protected function sidebar(array $elements): Block
    {
        return new Block([
            Block::HANDLE => 'sidebar',
            Block::NAME => trans('narsil-cms::ui.sidebar'),
            Block::RELATION_ELEMENTS => $elements
        ]);
    }

    #endregion
}
